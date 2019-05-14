<?php
include_once('controllers/crud.php');
class Fixtures extends Crud{
	public function __construct($pages=null){
            if($this->checkLogin()){
                if($pages[1] != null){
                        $this->{$pages[1]}($pages);
                }
            }
	}
        
        public function search($page){
			$where = 'name LIKE "%'.$_POST['search'].'%"';
			if(isset($_POST['fixtures']['term'])){	
				$where = $_POST['fixtures']['term'].' LIKE "%'.$_POST['search'].'%"';
			}
            $this->info = $this->query('SELECT * FROM fixture_type WHERE '.$where);
            $this->display = 'none';
            echo json_encode($this->info);
        }
	
	public function listFixtures(){
            $this->info = $this->listItems(null,null,null,null,'fixture_type');
            $this->render('fixtures/list');
	}
	
	public function listNewFixtures(){
            $this->info = $this->listItems(null,null,null,null,'fixture_type',array('date'=>'NOW()'));
            $this->render('fixtures/list');
	}
	
	public function listPanels(){
        $this->info = $this->query('SELECT * FROM panels WHERE breaker_type != ""');
		$this->render('fixtures/panels');
	}
	
	public function createPanel(){
        if($this->create('panels','fixtures/createPanel',array('name'=>'','voltage'=>'','manufacturer'=>'','breaker_type'=>'','amp_rating'=>''))){
			if(isset($_POST['icon'])){
				copy('uploads/icon/'.$_POST['icon'].'.png', 'uploads/icon/'.$_POST['panels']['name'].'.png');
				$this->checkFixtureType();
			}
			if(!isset($_GET['ajax'])){
				header('LOCATION: ?page=fixtures/listPanels');
			} else {
				$this->info = $this->query('SELECT * FROM panels WHERE panel_id='.$this->saveId);
				$this->display = 'none';
				echo json_encode($this->info[0]);
			}
		}
	}
	
	public function editPanel($id=null){
		$info = $this->query('SELECT * FROM panels WHERE panel_id='.$id[2]);
		$info = $info[0];

		if($this->create('panels','fixtures/createPanel',array('panel_id'=>$info['panel_id'],'name'=>$info['name'],'voltage'=>$info['voltage'],'manufacturer'=>$info['manufacturer'],'breaker_type'=>$info['breaker_type'],'amp_rating'=>$info['amp_rating']))){
			if(isset($_POST['icon'])){
				copy('uploads/icon/'.$_POST['icon'].'.png', 'uploads/icon/'.$_POST['panels']['name'].'.png');
				$this->checkFixtureType();
			}
			header('LOCATION: ?page=fixtures/listPanels');
		}
	}
	
	public function searchPanel($page=null){
		$where = '';
		if(isset($_POST['search'])) $where = 'AND name LIKE "%'.$_POST['search'].'%"';
		if(isset($_POST['panel']['term'])){	
			$where = 'AND '.$_POST['panel']['term'].' LIKE "%'.$_POST['search'].'%"';
		}
		$this->info = $this->query('SELECT * FROM panels WHERE type != "" '.$where);
		$this->display = 'none';
		return json_encode($this->info);
	}
	
	public function listTimer(){
        $this->info = $this->query('SELECT * FROM panels WHERE type != ""');
		$this->render('fixtures/timers');
	}
	
	public function checkFixtureType(){
		$name = "";
		if(isset($_POST['fixture_type']['name'])){
			$name =  $_POST['fixture_type']['name'];
		}else if(isset($_POST['panels']['name'])){
			$name = $_POST['panels']['name'];
		}else{
			$name = $_POST['type'];
		}
		$check = $this->query('SELECT * FROM fixture_type WHERE name = "'.$name.'"');
		if(sizeof($check) < 1){
			$this->save("fixture_type",array("name"=>$name,"user_id"=>$_SESSION['user_id']));
		}
	}
	
	public function createTimer(){
        if($this->create('panels','fixtures/createTimer',array('name'=>'','voltage'=>'','manufacturer'=>'','type'=>''))){
			if(isset($_POST['icon'])){
				$name = (isset($_POST['panels']['name']))?$_POST['panels']['name']:$_POST['type'];
				copy('uploads/icon/'.$_POST['icon'].'.png', 'uploads/icon/'.$name.'.png');
				checkFixtureType();
			}
			if(!isset($_GET['ajax'])){
				header('LOCATION: ?page=fixtures/listTimer');
			} else {
				$this->info = $this->query('SELECT * FROM panels WHERE panel_id='.$this->saveId);
				$this->display = 'none';
				echo json_encode($this->info[0]);
			}
		}
	}
	
	public function editTimer($id=null){
		$info = $this->query('SELECT * FROM panels WHERE panel_id='.$id[2]);
		$info = $info[0];
		
        if($this->create('panels','fixtures/createTimer',array('panel_id'=>$info['panel_id'],'name'=>$info['name'],'voltage'=>$info['voltage'],'manufacturer'=>$info['manufacturer'],'type'=>$info['type']))){
			if(isset($_POST['icon'])){
				$name = (isset($_POST['panels']['name']))?$_POST['panels']['name']:$_POST['type'];
				copy('uploads/icon/'.$_POST['icon'].'.png', 'uploads/icon/'.$name.'.png');
				checkFixtureType();
			}
			header('LOCATION: ?page=fixtures/listTimer');
		}
	}
	
	public function removePanel($id){
			$info = $this->query('SELECT * FROM panels WHERE panel_id='.$id[2]);
            $this->delete('panels', array('panel_id'=>$id[2]));
			if(is_file('uploads/icon/'.$info[0]['name'].'.png')){
				unlink('uploads/icon/'.$info[0]['name'].'.png');
			}
            header('LOCATION: ?page=fixtures/listPanels');
	}
	
	public function removeTimer($id){
			$info = $this->query('SELECT * FROM panels WHERE panel_id='.$id[2]);
            $this->delete('panels', array('panel_id'=>$id[2]));
			if(is_file('uploads/icon/'.$info[0]['name'].'.png')){
				unlink('uploads/icon/'.$info[0]['name'].'.png');
			}
            header('LOCATION: ?page=fixtures/listTimer');
	}
	
	public function view($id){
            $this->info = $this->query('SELECT * FROM fixture_type');
            $this->render('fixtures/view');
	}
        
	public function displayIcon($type, $id=null){
		if(is_file('uploads/icon/'.$id.'.png')){
			echo 'uploads/icon/'.$id.'.png';      
		}
	}
	
	public function createForm($id=null){
            if($this->create('fixture_type','fixtures/create',array('name'=>'','watts'=>'','description'=>'','type'=>''))){
                if(isset($_FILES['upload'])){
                    move_uploaded_file($_FILES['upload']['tmp_name'], 'uploads/icon/'.$_POST['fixture_type']['name'].'.png');
                }
				if(isset($_POST['icon'])){
					$name = '';
					if(isset($_POST['panels']['name'])){
						$name = $_POST['panels']['name'];
					}else if(isset($_POST['fixture_type']['type'])){
						$name = $_POST['fixture_type']['type'];
					}else{
						$name = $_POST['type'];
					}
					copy('uploads/icon/'.$_POST['icon'].'.png', 'uploads/icon/'.$name.'.png');
					$this->checkFixtureType();
				}
                if(!isset($_GET['ajax'])){
                    header('LOCATION: ?page=fixtures/listFixtures');
                } else {
                    $this->info = $this->query('SELECT * FROM fixture_type WHERE fixture_type_id='.$this->saveId);
                    $this->display = 'none';
					echo json_encode($this->info[0]);
                }
            }
	}
        
	public function editForm($id=null){
		$info = $this->query('SELECT * FROM fixture_type WHERE fixture_type_id='.$id[2]);
		if($this->create('fixture_type','fixtures/create',array('fixture_type_id'=>$info[0]['fixture_type_id'],'name'=>$info[0]['name'],'watts'=>$info[0]['watts'],'description'=>$info[0]['description'],'type'=>$info[0]['type']))){
			if(isset($_POST['icon'])){
				$name = (isset($_POST['fixture_type']['name']))?$_POST['fixture_type']['name']:$_POST['type'];
				copy('uploads/icon/'.$_POST['icon'].'.png', 'uploads/icon/'.$name.'.png');
				checkFixtureType();
			}
			header('LOCATION: ?page=fixtures/listFixtures');
		}
	}
		
	public function editFixture($id=null){
		$info = $this->query('SELECT * FROM fixture_info WHERE fixture_id='.$id[2]);
		if(sizeof($info) < 1){
			if($this->create('fixture_info','fixtures/fixture_info',array('fixture_id'=>'','watts'=>'','burnhours'=>''))){
				header('LOCATION: ?page=fixtures/listFixtures');
			}
		} else {
			if($this->create('fixture_info','fixtures/fixture_info',array('fixture_id'=>$info[0]['fixture_id'],'watts'=>$info[0]['watts'],'burnhours'=>$info[0]['burnhours']))){
				header('LOCATION: ?page=fixtures/listFixtures');
			}
		}
	}
        
	public function requestMaintenance($id=null){
		if($this->create('maintenance','maintenance/create',array('description'=>'','type'=>'fixture','type_id'=>$id[2],'date'=>'NOW()'))){
				header('LOCATION: ?page=fixtures/success');
		}
	}
        
	public function success(){
		echo 'congratulations';
	}
	
	public function remove($id){
			$info = $this->query('SELECT * FROM fixture_type WHERE fixture_type_id='.$id[2]);
            $this->delete('fixture_type', array('fixture_type_id'=>$id[2]));
			unlink('uploads/icon/'.$info[0]['name'].'.png');
            header('LOCATION: ?page=fixtures/listFixtures');
	}
	
	public function viewAll(){
            $this->ListNotes();
	}
}
?>