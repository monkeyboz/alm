<?php
  class db {
    var $username = DB_USERNAME;
    var $password = DB_PASSWORD;
    var $server = LOCALHOST;
    var $database = DB_NAME;
    var $connect;
	var $title;
    var $contents = '';
    var $debug = '';
    var $pagination = array();
    var $pageQ = array();
    var $display = 'contents.php';
    var $breadcrumbs = array();
    var $memcached;
    var $cacheTime = 0;
    
    var $uploadDir = '';
    var $userDir = '';
    
    public function db($page = null){
	  $this->uploadDir .= '/uploads/';
	  $this->userDir .= '/uploads/usersDir/';
	  
      switch($page[1]){
        case 'search':
          search();
          break;
        case 'save':
          save();
          break;
        case 'render':
          render();
          break;
        case 'read':
          read();
          break;
        default:
          break;
      }
    }
	
	public function likeContent($userid, $content){
		switch($content['type']){
			case 'calendar':
				$likecontent = $this->query('SELECT * FROM contents WHERE type="calendar" AND (user_id='.$userid.' OR name LIKE "%'.$this->getLongestWord($content['name']).'%") ORDER BY created DESC LIMIT 0,10');
				$contentStringHolder = '<a href="?page=user/content/show/[content_id]">[name] - [date]</a>';
				break;
			case 'image':
				$likecontent = $this->query('SELECT * FROM contents WHERE type="image" AND (user_id='.$userid.' OR name LIKE "%'.$this->getLongestWord($content['name']).'%" OR type="image") ORDER BY created DESC LIMIT 0,10');
				$contentStringHolder = '<div style="width: 90px; height: 90px; overflow: hidden; float: left; margin: 5px;"><a href="?page=user/content/show/[content_id]">[imagelink]</a></div>';
				
				$content = '<div id="relatedContent">';
				$content .= '<h3>Related Content</h3>';
				
				foreach($likecontent as $l){
					$contentString = $contentStringHolder;
					$contentString = str_replace('[content_id]', $l['content_id'], $contentString);
					$contentString = str_replace('[imagelink]', $this->getContent($l['content_id']), $contentString);
					$contentString = str_replace('[name]', $l['name'], $contentString);
					$contentString = str_replace('[type]', $l['type'], $contentString);
					$content .= $contentString;
				}
				$content .= '</div>';
				
				break;
			default:
				$likecontent = $this->query('SELECT * FROM contents WHERE type="article" AND (user_id='.$userid.' OR name LIKE "%'.$this->getLongestWord($content['name']).'%") ORDER BY created DESC LIMIT 0,10');
				$contentStringHolder = '<a href="?page=user/content/show/[content_id]">[name]</a>';
				
				$content = '<div id="relatedContent">';
        		$content .= '<h3>Related Content</h3>';
		
				foreach($likecontent as $l){
					$contentString = $contentStringHolder;
					$contentString = str_replace('[content_id]', $l['content_id'], $contentString);
					$contentString = str_replace('[name]', $l['name'], $contentString);
					$contentString = str_replace('[type]', $l['type'], $contentString);
					$content .= $contentString;
				}
				$content .= '</div>';
				
				break;	
		}
		
		return $content;
	}
	
	public function getLongestWord($string){
		$words = explode(' ', $string);
		$longestWord = '';
		foreach($words as $w){
			if(strlen($w) > strlen($longestWord)){
				$longestWord = $w;	
			}
		}
		return $longestWord;
	}
    
    public function getContent($id){
    	$content = $this->query('SELECT * FROM contents WHERE content_id="'.$id.'"');
    	$content = $content[0];
    	if(isset($content['type'])){
    		switch($content['type']){
    			case 'video':
    				$holder = explode('v=', $content['data']);
    				$holder = explode('&', $holder[1]);
    				$holder = $holder[0];
    				return '<object width="100%" height="400"><param name="movie" value="http://www.youtube.com/v/'.$holder.'?version=3&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$holder.'?version=3&amp;hl=en_US" type="application/x-shockwave-flash" width="100%" height="400" allowscriptaccess="always" allowfullscreen="true"></embed></object>';
    				break;
    			case 'image':
    				return '<img src="'.$this->userDir.$content['user_id'].'/'.$content['content_id'].'.'.$content['data'].'" style="width: 100%;" class="images"/>';
    				break;
    			case 'music':
    				return '<embed width="100%" height="20" type="application/x-shockwave-flash" src="'.MAIN_DIR.'swf/singlemp3player.swf" pluginspage="http://www.adobe.com/go/getflashplayer" flashvars="file='.$this->userDir.$content['user_id']."/".$content['content_id'].'.'.$content['data'].'"/>';
    				break;
    		}
    	} else {
    		echo 'No Content For This Layout.';
    	}
    }
    
    public function comments($type, $id){
    	$this->comments['content_type'] = $type;
    	$this->comments['id'] = $id;
    	$this->comments['holder'] = $this->query('SELECT c.*, u.username, u.city, u.state FROM comments AS c JOIN users AS u ON u.user_id=c.user_id WHERE c.content_type="'.$type.'" AND c.content_id="'.$id.'" ORDER BY date DESC');
    	foreach($this->comments['holder'] as $k=>$c){
    	   $this->comments['holder'][$k]['description'] = preg_replace('/@(\w+)/i', '<a href="?page=user/display/${1}">@${1}</a>', $this->addParagraphs($this->comments['holder'][$k]['description']));
    	   $this->comments['holder'][$k]['description'] = preg_replace('/#(\w+)/i', '<a href="?page=search/tag/#${1}">#${1}</a>', $this->addParagraphs($this->comments['holder'][$k]['description']));
        }
    	return $this->comments;
    }
    
    public function saveComment($type, $id){
    	
    }
    
    public function getUserPic($id){
    	$profilePics = $this->userDir.$id.'/profile.jpg';
    	if(is_file($profilePics)){
    		return $profilePics;
    	} else {
    		return $this->uploadDir.'profile.jpg';
    	}
    }
    
   	public function template($file){
    	$h = fopen(getcwd().'/views/'.$file.'.php', 'r');
    	$content = fread($h, filesize(getcwd().'/views/'.$file.'.php'));
    	fclose($h);
    	return $content;
    }
    
    public function checkLogin(){
      if(isset($_SESSION['username'])){
        return true;
      } else {
        return false;
      }
    }
    
    public function conn(){
      $this->connect = mysql_connect($this->server, $this->username, $this->password);
      mysql_select_db($this->database);
    }
    
    public function disc(){
      mysql_close($this->connect);
    }
    
    public function processPost(){
      $where = array();
      if(isset($_POST) && sizeof($_POST)){
        foreach($_POST as $k => $p){
          $where[] = $k.' LIKE "%'.$p.'%"';
          $this->pageQ[$k] = $p;
        }
      } else {
        foreach($_GET as $k => $p){
          if($k != 'pagenum' && $k != 'page' && $k != 'ajax'){
            $where[] = $k.' LIKE "%'.$p.'%"';
            $this->pageQ[$k] = $p;
          }
        }
      }
      return $where;
    }
    
    public function query($query){
      $this->conn();
      if(DEBUG == 1){
        $this->debug .= $query.'<hr/>';
      }
      $db_result = mysql_query($query) or $this->debug .= mysql_error();
      
      $result = array();
      while($info = mysql_fetch_assoc($db_result)){
		foreach($info as $k=>$i){
			$info[$k] = stripslashes($i);
		}
		$result[] = $info;
      }
      
      $this->disc();
      return $result;
    }
    
    public function impressions($type="page", $id=0){
         $updates = date('Y-m-d 23:59:59');
         $impression = $this->query('SELECT * FROM impressions WHERE type="'.$type.'" AND type_id="'.$id.'" AND ip="'.$_SERVER['REMOTE_ADDR'].'" AND date<"'.$updates.'" ORDER BY date DESC LIMIT 1');
            if(sizeof($impression) > 0){
                ++$impression[0]['count'];
                $this->edit('impressions', $impression[0], array('id'=>$impression[0]['id']));
            } else {
                $impression = array('type'=>$type, 'type_id'=>$id, 'ip'=>$_SERVER['REMOTE_ADDR']);
                $this->save('impressions', $impression);
            }
    }
    
    public function showUser($u){
        $impressions = $this->query('SELECT COUNT(*) FROM impressions WHERE type="user" AND type_id="'.$u['user_id'].'"');
        $comments = $this->query('SELECT COUNT(*) FROM comments WHERE content_type="user" AND content_id="'.$u['user_id'].'"');
        $content = $this->template('user/show_user');
        $content = str_replace('[username]', $u['username'], $content);
        $content = str_replace('[city]', $u['city'], $content);
        $content = str_replace('[state]', $u['state'], $content);
        $content = str_replace('[views]', $impressions[0]['COUNT(*)'], $content);
        $content = str_replace('[comments]', $comments[0]['COUNT(*)'], $content);
        $content = str_replace('[image]', $this->getUserPic($u['user_id']), $content);
        echo $content;
    }
    
    public function addParagraphs($text){
       // Add paragraph elements
       $lf = chr(10);
       return preg_replace('/\n(.*)\n/Ux' , $lf.'<p>'.$lf.'$1'.$lf.'</p>'.$lf, $text);
    }
	
	public function logout(){
		session_destroy();
		header('Location: index.php');
	}
    
    public function save($table=null, $info){
      if($table == null){
        $table = get_class($this);
      }
      $this->conn();
      $values = '(';
      $keys = '(';
      foreach($info as $k => $v){
        if($k != 'submit'){
          $keys .= $k.',';
          if(!is_numeric($v) && $v != 'NOW()'){ $v = '"'.mysql_real_escape_string($v).'"'; }
          $values .= $v.',';
        }
      }
      $keys = substr($keys,0,-1);
      $values = substr($values,0,-1); 
      $values .= ')';
      $keys .= ')';
      
      $query = 'INSERT INTO '.$table.' '.$keys.' VALUES '.$values;
      if(DEBUG == 1){ $this->debug .= $query.'<hr/><br/>'; }
      mysql_query($query) or $this->debug .= mysql_error().'<br/>';
      $insert_id = mysql_insert_id();
      
      $this->disc();
      return $insert_id;
    }
    
    public function delete($table, $info){
      $this->conn();
      $where_column = '';
      $where_value = '';
      
      foreach($info as $wc => $wv){
        $where_column .= $wc;
        $where_value .= $wv;
      }
      
      $query = 'DELETE FROM '.$table.' WHERE '.$where_column.' = "'.$where_value.'"';
      if(DEBUG == 1){ $this->debug .= $query.'<hr/>'; }
      mysql_query($query);
      $this->disc();
    }
    
    public function edit($table, $info, $where){
      $this->conn();
      $values = '';
      foreach($info as $k => $v){
        if($k != 'submit'){
          if(!is_numeric($v) && $v != 'NOW()'){ $v = '"'.mysql_real_escape_string($v).'"'; }
          $values .= $k.'='.$v.',';
        }
      }
      $values = substr($values,0,-1); 
      
      $where_column = '';
      $where_value = '';
      foreach($where as $wc => $wv){
        $where_column = $wc;
        $where_value = $wv;
      }
      
      $query = 'UPDATE '.$table.' SET '.$values.' WHERE '.$where_column.' = '.$where_value;
      if(DEBUG == 1){ $this->debug .= $query.'<hr/><br/>'; }
      mysql_query($query) or $this->debug .= mysql_error().'<br/>';
      $insert_id = mysql_insert_id();
      
      $this->disc();
      return $insert_id;
    }
    
    public function render($file, $cache=true){
      if($cache){
	      ob_start();
	      include('views/'.$file.'.php');
	      $this->contents .= ob_get_contents();
	      ob_end_clean();
      } else {
      	  include('views/'.$file.'.php');
      }
    }
    
    public function showError($error, $array=null){
      if($array == null){
        $array = get_class($this);
      }
      if(isset($this->errors[$array][$error]['error'])){
        echo '<div style="color: #ff0000;">'.str_replace('_', ' ', $this->errors[$array][$error]['error']).'</div>';
      }
    }
    
    public function validate($info){
      $error = array('total'=>0);
        foreach($info as $key => $p){
          if($p == ''){
            ++$error['total'];
            $error[$key]['error'] = $key.' is empty';
            $error['values'][$key] = $p;
          } elseif(is_array($p)) {
            $error['values'][$key] = $p['not_required'];
          } else {
            $error['values'][$key] = $p;
          }
        }
        return $error;
    }
    
    public function logs($info){
        if(isset($_SESSION['userId'])){
    	   $logInfo = array('user_id'=>$_SESSION['userId'], 
      				'description' => $info);
        } else {
            $logInfo = array('user_id'=>0, 'description'=>$info);
        }
		  $this->save('user_logs', $logInfo);
    }
  }
?>