<?php

	class User extends ClassBase {
		private $just_logged_in = 0;
		private $cookie_prefix = 'crowdv_';
			
		public function add($username, $password, $password2, $email) {
			$username = trim($username);
			$email = trim($email);
		
			$username_validator = new Validator();
			$username_validator->set_required()->set_length(1, 25);
			
			$password_validator = new Validator();
			$password_validator->set_required()->set_length(6, 20);
			
			$password2_validator = new Validator();
			$password2_validator = $password2_validator->add_condition('==', $password);

      $email_validator = new Validator();
			$email_validator->set_required()->add_filter('email');
			
			$validation = new Validation();
			$validation->add('username', $username_validator);
			$validation->add('password', $password_validator);
			$validation->add('password2', $password2_validator);
			$validation->add('email', $email_validator);
			
			$validation_result = $validation->validate();
			switch ($validation_result['status']) {
				case 'valid':
					$user = $this->db->dispense('user');
					$user->username = $username;
					$user->password = sha1($password);
					$user->email = $email;
					$user->time = time();
					$user->lastip = $_SERVER['REMOTE_ADDR'];
					$user_store = $this->db->store($user);
					switch ($user_store['status']) {
						case 'stored':
							return array('status' => 'success');
							break;
							
						case 'exists':
							return array('status' => 'exists', 'field' => $user_store['field']);
							break;
					}
					break;
				
				default:
					return array('status' => $validation_result['status'], 'field' => $validation_result['field']);
					break;
			}
		}
		
		public function login($username, $password) {
			$encrypted_password = sha1($password);
			$logged_user = $this->db->find('user', "username='". $username ."' and password='". $encrypted_password ."'");
			if (count($logged_user) == 1) {
				if (setcookie($this->cookie_prefix .'username', $username, time()+31536000, '/') && setcookie($this->cookie_prefix .'password', $encrypted_password, time()+31536000, '/')) {
					$this->just_logged_in = current($logged_user)->userid;
					return true;
				} else {
					return false;
				}
			}
		}
		
		public function logged_user() {
			if ($this->just_logged_in > 0) {
				return $this->just_logged_in;
			}
			
			if (isset($_COOKIE[$this->cookie_prefix .'username']) && isset($_COOKIE[$this->cookie_prefix .'password'])) {
				$username = trim($_COOKIE[$this->cookie_prefix .'username']);
				$password = trim($_COOKIE[$this->cookie_prefix .'password']);
				
				if ($username != '' && $password != '') {
					$logged_in_users = $this->db->find('user', "username='". $username ."' and password='". $password ."'");
					if (count($logged_in_users) == 1) {
						return current($logged_in_users)->userid;
					}
				}
			}
			
			return 0;
		}
		
		public function logout() {
			if (setcookie($this->cookie_prefix .'username', '', time()-100, '/') && setcookie($this->cookie_prefix .'password', '', time()-100, '/')) {
				return true;
			} else {
				return false;
			}
		}
		
		public function get_user($userid) {
			$user = $this->db->load('user', $userid);
			if ($user->userid > 0) {
				 return $user;
			}
			
			return false;
		}
	}

?>