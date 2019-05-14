<?php
include_once('controllers/db.php');
class Crud extends db{
	public function __construct(){
            
	}
	
	//This is the list items function
	//Used in conjunction with listing column information
	//Variables passed are 
	/*	Table Id = specifies which column is being searched
		Id = for the column
		Parent Id = the parent id for the column (if there is one)
		Table = the table being searched in
		Where (array) = an array
	*/
	public function listItems($table_id=null, $id=null, $parent_id=null, $parent_id=null, $table=null, $where=array(), $limit=10, $orderBy='date'){
		$query = 'SELECT * FROM '.$table;
		$page = (isset($_GET['page']))?0:$_GET['page'];
		
		$whereHolder = '';
		if(is_array($where)){
			foreach($where as $k=>$w){
				$whereHolder = ' AND '.$k.'="'.$w.'"';
			}
		}
		if($id != null){
			$query .= ' WHERE '.$table_id.'='.$id;
			$query .= $whereHolder;
			
		} else {
			if($parent_id != null){
				$query .= ' WHERE '.$parent_id.'='.$parent_table;
			} else {
				if($whereHolder != ''){
					$query .= ' WHERE '.substr($whereHolder,4,strlen($whereHolder));
				}
			}
		}
		return $this->query($query.' LIMIT '.$page.','.$limit);
	}
	
	public function processFunction($values, $errors, $render, $table){
		if($errors['total'] > 0){
			$this->info = $values;
			$this->errors = $errors;
			$this->render($render);
			return false;
		} else {
			$this->saveId = $this->save($table,$values);
			return true;
		}
	}
	
	public function create($table, $render, $args){
		if(isset($_POST[$table])){
			$errors = $this->validate($_POST[$table]);
			$values = $errors['values'];
			return $this->processFunction($values,$errors,$render,$table);
		} else {
			$this->info = $args;
			$this->render($render);
			return false;
		}
	}
	
	public function editOptions($type,$id){
		$option_links = [
				'property'=>array(
						'view'		=> '?page=properties/propertyDisplay/'.$id,
						'edit'		=> '?page=properties/editForm/'.$id,
						'delete'	=> '?page=properties/remove/'.$id
					),
				'fixture' => array(
						'view'		=> "?page=fixtures/view/".$id,
						'edit'		=> "?page=fixtures/remove/".$id,
						'delete'	=> "?page=fixtures/editForm/".$id
					),
				'fixture_type' => array(
						'view'		=> "?page=fixtures/view/".$id,
						'edit'		=> "?page=fixtures/remove/".$id,
						'delete'	=> "?page=fixtures/editForm/".$id
					),
				'user'	=> array(
						'view'		=>	'?page=users/view/'.$id,
						'edit'		=> '?page=users/remove/'.$id,
						'delete'	=> '?page=users/editForm/'.$id
					)
			];
			
			
			
		$options = '<div><a href="'.$option_links[$type]['view'].'">View</a>';
		$user = $this->query('SELECT user_type FROM users WHERE user_id = '.$_SESSION['user_id']);
		if($user[0]['user_type'] == 'superadmin' || $user[0]['user_type'] == 'superuser'){
			$options .= '| <a href="'.$option_links[$type]['edit'].'" class="popup">Edit</a> | <a href="'.$option_links[$type]['delete'].'" class="delete">Delete</a>';
		}
		echo $options.'</div>';
	}
}
?>