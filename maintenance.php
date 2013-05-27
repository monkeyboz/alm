<?php
class Maintenance extends db{
	
	public function __construct(){
		if(!isset($this->loggedin())){
			header('Location: index.php');
		}
	}
	
	public function listMaintenance($id=null,$where=array(), $limit=10, $orderBy='date'){
		$query = 'SELECT * FROM maintenance';
		$page = (isset($_GET['page']))?0:$_GET['page'];
		if($id != null){
			$whereHolder = '';
			foreach($where as $k=>$w){
				$whereHolder = ' AND '.$k.'="'.$w.'"';
			}
			$query .= ' WHERE property_id='.$id;
			$query .= $whereHolder;
		} else {
			$query .= ' WHERE user_id='.$_SESSION['user_id'].);
		}
		return $this->query($query.' LIMIT '.$page.','.$limit);
	}
	
	public function listMaintenanceByProperty($id=null,$limit){
		if($id != null){
			$this->info = $this->listMaintenance($id);
			$this->render('maintenance/list');
		} else {
			$this->error = 'You must place a Property ID to display the maintenance requests.';
			$this->render('default/error');
		}
	}
	
	public function listNewMaintenance($id=null,$limit=10,){
		$this->listMaintenance($id, array('false'=>'active'),$limit);
	}
	
	public function listNewMaintenanceByProperty($id=null,$limit=10){
		$this->listMaintenance($id,array('false'=>'active'),$limit);
	}
	
	public function create($id){
		if(isset($_POST['maintenance'])){
			$errors = $this->validate($_POST['maintenance']);
			$values = $errors['values'];
			if($errors['total'] > 0){
				$this->info = $values;
				$this->render('maintenance/create');
			} else {
				$this->save('maintenance',$values);
				$this->listMaintenance();
			}
		} else {
			$this->info = null;
			$this->render('maintenance/create');
		}
	}
	
	public function edit($id){
		if(isset($_POST['maintenance'])){
			$errors = $this->validate($_POST['maintenance']);
			$values = $errors['values'];
			if($errors['total'] > 0){
				$this->info = $values;
				$this->render('maintenance/create');
			} else {
				$this->save('maintenance',$values);
				$this->listMaintenance();
			}
		} else {
			$this->info = $this->query('SELECT * FROM maintenance WHERE maintenance_id='.$id);
			$this->render('maintenance/create');
		}
	}
}
?>