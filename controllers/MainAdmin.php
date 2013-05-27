<?php
include_once('controllers/crud.php');
include_once('controllers/users.php');
include_once('controllers/properties.php');
class MainAdmin extends Crud{
	var $notes;
	var $properties;
	
	public function MainAdmin(){
            if($this->checkLogin()){
		$this->users = new Users();
		$this->properties = new Properties();
		$this->display();
            }
	}
	
	private function display(){
		$list = $this->query('SELECT * FROM properties WHERE user_id='.$_SESSION['user_id']);
		$this->users->listMaintenance();
		$this->properties->listProperties();
		$this->propertyDisplay = '<div>'.$this->properties->contents.'</div>';
		$this->maintenanceDisplay = '<div>'.$this->users->contents.'</div>';
		$this->render('mainadmin/display');
	}
}
?>