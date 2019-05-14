<?php
include_once('controllers/crud.php');
class Users extends Crud{
	public function __construct($pages=null){
            if($this->checkLogin()){
		if($pages != null){
			$this->{$pages[1]}($pages);
		}
            }
	}
        
        public function search(){
            $this->info = $this->query('SELECT * FROM users WHERE '.$_POST['users']['value'].' LIKE "%'.$_POST['users']['search'].'%"');
            $this->render('users/list');
        }
	
	public function listUsers(){
            $this->info = $this->listItems('parent',$_SESSION['user_id'],null,null,'users');
            $this->render('users/list');
	}
	
	public function listMaintenance(){
		$this->info = $this->query('SELECT * FROM maintenance AS m JOIN fixtures AS f ON f.fixture_id=m.type_id JOIN properties AS p ON p.property_id=f.property_id JOIN users AS u ON p.user_id=u.user_id WHERE u.user_id='.$_SESSION['user_id'].' OR parent='.$_SESSION['user_id']);
		$this->render('properties/listFixtures');
	}
	
	public function listNewUsers(){
            $this->info = $this->listItems(null,null,null,null,'users',array('date'=>'NOW()'));
            $this->render('users/list');
	}
	
	public function view($id){
            $this->info = $this->query('SELECT * FROM users WHERE user_id='.$id[2]);
            $this->render('users/view');
	}
	
	public function createForm($id=null){
		if($this->create('users','users/create',array('username'=>'','password'=>'','email'=>'','user_type'=>'','phone'=>'','first_name'=>'','last_name'=>'','parent'=>''))){
				header('LOCATION: ?page=users/listUsers');
		}
	}
	
	public function editForm($id=null){
            $info = $this->query('SELECT * FROM users WHERE user_id='.$id[2]);
            $parent = $this->query('SELECT * FROM users WHERE username="'.$info[0]['parent'].'"');
            $query_array = array('user_id'=>$id[2],
            					 'username'=>$info[0]['username'],
            					 'password'=>$info[0]['password'],
            					 'email'=>$info[0]['email'],
            					 'phone'=>$info[0]['phone'],
            					 'last_name'=>$info[0]['last_name'],
            					 'first_name'=>$info[0]['first_name'],
            					 'user_type'=>$info[0]['user_type']);
        	if(sizeof($parent) != 0){
        		$query_array['parent'] = $parent[0]['username'];
        	}
            if($this->create('users','users/create',$query_array)){
                    header('LOCATION: ?page=users/listUsers');
            }
	}
	
	public function remove($id){
            $this->delete('users', array('user_id'=>$id[2]));
            header('LOCATION: ?page=users/listUsers');
	}
	
	public function viewAll(){
            $this->ListNotes();
	}
        
        public function logout(){
            session_destroy();
            header('LOCATION: ?page=main');
        }
}
?>