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
		if(sizeof($id) > 3){
			$sub_types = array(
					'property'	=> array(
										'table'	=>'properties',
										'column_name'=>'name',
										'column_id'	=>'property_id',
										'query'	=>'properties as p ON p.property_id = n.sub_type_id'),
					'fixture'	=> array(
										'table'	=>'fixtures',
										'column_name'=>'type',
										'column_id'	=>'fixture_id',
										'query'	=>'fixtures as f ON f.fixture_id = n.sub_type_id'),
					'panel'		=> array(
										'table'	=>'panels',
										'column_name'=>'name',
										'column_id'	=>'panel_id',
										'query'	=>'panels as p ON p.panel_id = n.sub_type_id')
				);
			$this->item_info = $this->query('SELECT '.$sub_types[$id[3]]['column_name'].' as name, '.$sub_types[$id[3]]['column_id'].' as id FROM '.$sub_types[$id[3]]['table'].' WHERE '.$sub_types[$id[3]]['column_id'].' = '.$id[2]);
			$this->create('notes','notes/create',array('description'=>'','sub_type'=>$id[3],'sub_type_id'=>$id[2],'user_id'=>$_SESSION['user_id']));
		}else if($this->create('notes','notes/create',array('description'=>'','sub_type'=>'fixture','sub_type_id'=>$id[2],'user_id'=>$_SESSION['user_id']))){
			header('LOCATION: ?page=notes/listNotes');
		}else{
			
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