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
}
?>