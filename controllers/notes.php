<?php
include_once('controllers/crud.php');
class Notes extends Crud{
	public function __construct($pages=null){
            if($this->checkLogin()){
		if($pages != null){
			$this->{$pages[1]}($pages);
		}
            }
	}
	
	public function listNotes(){
		$this->info = $this->listItems('user_id',$_SESSION['user_id'],null,null,'notes',array('type'=>'notes'));
		$this->render('notes/list');
	}
	
	public function listNewNotes(){
		$this->info = $this->listItems('user_id',$_SESSION['user_id'],null,null,'notes',array('type'=>'notes'));
		$this->render('notes/list');
	}
	
	public function view($id){
		$this->info = $this->query('SELECT * FROM notes WHERE note_id='.$id[2]);
		$this->render('notes/view');
	}
	
	public function createForm($id=null){
		if($this->create('notes','notes/create',array('description'=>'','sub_type'=>'fixture','sub_type_id'=>$id[2],'user_id'=>$_SESSION['user_id']))){
			header('LOCATION: ?page=notes/listNotes');
		}
	}
	
	public function editForm($id=null){
		$info = $this->query('SELECT * FROM notes WHERE note_id='.$id[2]);
		if($this->create('notes','notes/create',array('note_id'=>$id[2],'description'=>$info[0]['description'],'sub_type'=>'fixture','sub_type_id'=>$info[0]['sub_type_id'],'user_id'=>$_SESSION['user_id']))){
			header('LOCATION: ?page=notes/listNotes');
		}
	}
	
	public function remove($id){
		$this->delete('notes', array('note_id'=>$id[2]));
		header('LOCATION: ?page=notes/listNotes');
	}
	
	public function viewAll(){
		$this->ListNotes();
	}
}
?>