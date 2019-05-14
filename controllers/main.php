<?php
	class main extends db{
		public function main($page){
                    $this->display = 'login';
                    if(isset($page[1])){
                        $this->{$page[1]}();
                    } else {
                        $this->login();
                    }
		}
                
                public function forgot(){
                    if(isset($_POST['forgot'])){
				$errors = $this->validate($_POST['forgot']);
				$values = $errors['values'];
				
				if($errors['total'] == 0){
					$info = $this->query('SELECT * FROM users WHERE email="'.$values['email'].'"');
					
					if(sizeof($info) > 0){
						mail($info[0]['email'],'Forgotten Password','You recently requested to recieve your password from ALM.\r\nHere is your ALM login and password.\r\nLogin: '.$info[0]['username'].'\r\nPassword: '.$info[0]['password'].'\r\n\r\nHope you have a great day!\r\n The ALM team');
						$this->render('main/forgotsuccess');
					} else {
                                            $this->errors = $errors;
                                            $this->errors['forgot']['email']['error'] = 'Email is not in our system.';
                                            $this->info = $values;
                                            $this->render('main/forgot');
					}
				} else {
                                    $this->info = $values;
                                    $this->errors['forgot'] = $errors;
                                    $this->render('main/forgot');
                                }
			} else {
                            $this->info = array('email'=>'Email');
                            $this->render('main/forgot');
			}
                }
		
		public function login(){
			if(isset($_POST['login'])){
				$errors = $this->validate($_POST['login']);
				$values = $errors['values'];
				
				if($errors['total'] == 0){
					$info = $this->query('SELECT * FROM users WHERE username="'.$values['username'].'" AND password="'.$values['password'].'"');
					
					if(sizeof($info) > 0){
						$_SESSION['username'] = $info[0]['username'];
						$_SESSION['user_id'] = $info[0]['user_id'];
						//$_SESSION['password'] = $info[0]['password'];
						$_SESSION['login'] = true;
                                                
						header('LOCATION: ?page=MainAdmin');
					} else {
                                            $this->info = $values;
                                            $this->errors['login']['username']['error'] = 'Your login credentials were incorrect please try again.';
                                            $this->render('main/login');
					}
				} else {
                                    $this->errors['login'] = $errors;
                                    $this->render('main/login');
                                }
			} else {
                            $this->info = null;
				$this->render('main/login');
			}
		}
	}
?>