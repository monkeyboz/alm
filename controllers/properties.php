<?php
include_once('controllers/crud.php');
class Properties extends Crud{
	public function __construct($pages=null){
            if($this->checkLogin()){
		if($pages != null){
			$this->{$pages[1]}($pages);
		}
            }
	}
        
        public function search(){
            if($_POST['search']['value'] == 'name'){
                $this->info = $this->query('SELECT * FROM properties WHERE '.$_POST['search']['value'].' LIKE "%'.$_POST['search']['search'].'%" AND user_id='.$_SESSION['user_id']);
            } elseif($_POST['search']['value'] == 'username') { 
                $this->info = $this->query('SELECT p.* FROM users AS u JOIN properties AS p ON p.user_id=u.user_id WHERE u.'.$_POST['search']['value'].' LIKE "%'.$_POST['search']['search'].'%"');
            } else {
                $this->info = $this->query('SELECT * FROM users AS u JOIN properties AS p ON p.user_id=u.user_id WHERE u.'.$_POST['search']['value'].' LIKE "%'.$_POST['search']['search'].'%" AND p.user_id='.$_SESSION['user_id']);
            }
            $this->render('properties/list');
        }
	
	public function listProperties(){
		$this->info = $this->listItems('user_id',$_SESSION['user_id'],null,null,'properties');
		$this->render('properties/list');
	}
	
	public function saveOrigin(){
		$origin = str_replace('(', '',$_POST['origin']);
		$origin = str_replace(')', '',$origin);
		$origin = explode(', ', $origin);
		$this->edit('properties', array('lat'=>$origin[0],'log'=>$origin[1]),array('property_id'=>$_POST['id']));
		echo $this->debug;
		exit();
	}
	
	public function listFixtures($id){
		$this->info = $this->listItems('property_id',$id[2],null,null,'fixtures');
                $this->id = $id[2];
		$this->render('properties/listFixtures');
	}
        
        public function listAllFixtures(){
			$where = (isset($_POST['search']))?' AND f.type LIKE "%'.$_POST['search'].'%"':'';
			if(isset($_POST['fixtures']['term'])){	
				$where = ' AND f.'.$_POST['fixtures']['term'].' LIKE "%'.$_POST['search'].'%"';
			}
			
            $this->info = $this->query('SELECT * FROM fixtures AS f JOIN properties AS p ON p.property_id=f.property_id JOIN users AS u ON p.user_id=u.user_id WHERE u.user_id='.$_SESSION['user_id'].' OR u.parent='.$_SESSION['user_id'].$where);
			$this->render('properties/listFixtures');
        }
        
        public function maintenanceLog($id){
            $info = $this->query('SELECT * FROM maintenance WHERE type_id='.$id[2]);
            
            if(sizeof($info) > 0){
                if($this->create('logs','maintenance/log',array('description'=>'','type'=>'','type_id'=>$info[0]['maintenance_id'],'user_id'=>$_SESSION['user_id']))){
                    header('LOCATION: ?page=properties/listProperties');
                }
            } else {
               if($this->create('maintenance','maintenance/create',array('description'=>'','type'=>'fixture','type_id'=>$id[2],'user_id'=>$_SESSION['user_id']))){
                    header('LOCATION: ?page=properties/listProperties');
                } 
            }
        }
	
	public function saveMarker(){
		if(isset($_POST['latlon'])){
			$position = explode(',', $_POST['latlon']);
			$type = explode('.', $_POST['icon']);
			$id = $_POST['id'];
			
			$lat = str_replace('(', '', $position[0]);
			$lon = str_replace(')', '', $position[1]);
			
			$test = $this->query('SELECT * FROM fixtures WHERE fixture_id='.$_POST['markerId']);
			if(sizeof($test) < 1){
				$id = $this->save('fixtures', array('property_id'=>$id,'lat'=>$lat,'lon'=>$lon, 'type'=>str_replace('uploads/icon/','',$type[0])));
				//echo $this->debug;
                                $info = $this->query('SELECT * FROM fixtures AS f Join fixture_type AS t ON t.name=f.type WHERE f.fixture_id='.$id);
				echo json_encode($info);
				die();
			} else {
				$this->edit('fixtures', array('lat'=>$lat,'lon'=>$lon), array('fixture_id'=>$_POST['markerId']));
				$info = $this->query('SELECT * FROM fixtures AS f Join fixture_type AS t ON t.name=f.type WHERE f.fixture_id='.$_POST['markerId']);
                                echo json_encode($info);
				die();
			}
		}
	}
	
	public function deleteMarker(){
            $this->delete('fixtures', array('fixture_id'=>$_POST['id']));
	}
        
        public function deleteFixture($id){
            $info = $this->query('SELECT * FROM fixtures WHERE fixture_id='.$id[2]);
            $this->delete('fixtures', array('fixture_id'=>$id[2]));
            header('LOCATION: ?page=properties/listFixtures/'.$info[0]['property_id']);
	}
	
	public function remove($id){
		$this->delete('properties', array('property_id'=>$id[2]));
		header('LOCATION: ?page=properties/listProperties');
	}
	
	function file_get_contents_curl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	public function propertyDisplay($pages){
		$this->info = $this->query('SELECT * FROM properties WHERE property_id='.$pages[2]);
		$this->fixtures = $this->query('SELECT * FROM fixtures WHERE property_id='.$pages[2]);
		$this->fixture_type = $this->query('SELECT * FROM fixture_type');
		$this->id = $pages[2];
        $this->navLayout = 'dashboard';
		$this->address = $this->file_get_contents_curl('http://maps.googleapis.com/maps/api/geocode/json?address='.str_replace(' ','%20',$this->info[0]['address']).'&sensor=true');
		$this->address = json_decode(str_replace(array('.', ' ', "\n", "\t", "\r"), '', $this->address));
		$this->display = 'maps';
		$this->render('properties/googlemaps');
	}
	
	public function createForm(){
            if($this->create('properties','properties/create',array('name'=>'','address'=>'','city'=>'','state'=>'','user_id'=>$_SESSION['user_id']))){
                    header('LOCATION: ?page=properties/listProperties');
            }
	}
        
	public function editForm($id=null){
		$info = $this->query('SELECT * FROM properties WHERE property_id='.$id[2]);
		if($this->create('properties','properties/create',array('property_id'=>$id[2],'name'=>$info[0]['name'],'state'=>$info[0]['state'],'city'=>$info[0]['city'],'address'=>$info[0]['address'],'user_id'=>$_SESSION['user_id']))){
				header('LOCATION: ?page=properties/listProperties');
		}
	}
	
	public function viewAll(){
            $this->ListNotes();
	}
        
        public function menuTest(){
            $this->info = $this->query('SELECT * FROM fixture_type LIMIT 0,10');
            $this->render('properties/menutest');
        }
}
?>