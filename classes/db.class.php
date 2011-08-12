<?php

	/*
		@class: database operations
		@author: ashraf m. samhouri <ashrafperformance@gmail.com>
		@revisions: 0
	*/
	class DB extends ClassBase {
		private $con;
		private $id_suffix = 'id';

		/*
			bool __construct(@dbhost, @dbuser, @dbpass, @dbname);
			This establishes a new connection to a specific MySQL database
			@dbhost: host address for database to connect to
			@dbuser: username to login with to database
			@dbpass: user's password to login to database
			@dbname: database name to connect to
			#return: true on success, exception on failure
		*/
		public function __construct($dbhost, $dbuser, $dbpass, $dbname) {
			parent::__construct();

			// new mysqli connection
			$this->con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
			$this->con->query("SET NAMES 'utf8'");
			
			// failed to establish connection?
			if (mysqli_connect_error()) throw new Exception(mysqli_connect_error());
			
			// on success
			return true;
		}
		
		public function get_id_field($table) {
			return $table . $this->id_suffix;
		}
		
		public function new_ball($table, $obj = NULL) {
			$ball = new DBBall($table, $obj);
			return $ball;
		}
		
		public function select_by_id($table, $id) {
			$table = trim($table);
			$id_field = $this->get_id_field($table);
			
		  $stmt = $this->con->prepare("select * from `". $table ."` where `". $id_field ."` = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->store_result();

			$row = array();
			$columns = array();
			$meta = $stmt->result_metadata();
			while ($column = $meta->fetch_field()) {
				$columns[] = &$row[$column->name];
			}
			call_user_func_array(array($stmt, 'bind_result'), $columns);
			               
			$stmt->fetch();
			
			$ball = $this->new_ball($table, $row);
			
			$stmt->free_result();
			$stmt->close(); 
			return $ball;
		}
		
		public function select($table, $conditions = '', $params = array()) {
			$table = trim($table);
			
		  $stmt = $this->con->prepare("select * from `". $table ."`". ($conditions != '' ? ' where '. $conditions : ''));
		  
		  if (!is_array($params)) {
		  	$params = array($params);
		  }
		  
		  if (count($params) > 0) {
		  	$params_types = '';
		  	$bind_params_list = array(&$params_types);
		  	foreach ($params as $key => $param) {
		  		if (is_int($param)) {
		  			$params_types .= 'i';
		  		} elseif (is_string($param)) {
		  			$params_types .= 's';
		  		} elseif (is_double($param)) {
		  			$params_types .= 'd';
		  		} else {
		  			$params_types .= 'b';
		  		}
		  		
		  		$bind_params_list[] = &$params[$key];
		  	}
		  	call_user_func_array(array($stmt, 'bind_param'), $bind_params_list);
			}
			$stmt->execute();
			$stmt->store_result();

			$row = array();
			$columns = array();
			$meta = $stmt->result_metadata();
			while ($column = $meta->fetch_field()) {
				$columns[] = &$row[$column->name];
			}
			call_user_func_array(array($stmt, 'bind_result'), $columns);
			               
			$results = array();
			$c = array();
			while ($stmt->fetch()) {
				$ball = $this->new_ball($table, $row);
        $results[] = $ball;
			}
			
			$stmt->free_result();
			$stmt->close(); 
			return $results;
		}
		
		public function select_query($query, $params = array()) {
			$table = preg_replace('/^select(.*)from(\s+)/siU', '\\4', $query);
			$table = explode(' ', $table);
			$table = $table[0];
			
		  $stmt = $this->con->prepare($query);
		  
		  if (!is_array($params)) {
		  	$params = array($params);
		  }
		  
		  if (count($params) > 0) {
		  	$params_types = '';
		  	$bind_params_list = array(&$params_types);
		  	foreach ($params as $key => $param) {
		  		if (is_int($param)) {
		  			$params_types .= 'i';
		  		} elseif (is_string($param)) {
		  			$params_types .= 's';
		  		} elseif (is_double($param)) {
		  			$params_types .= 'd';
		  		} else {
		  			$params_types .= 'b';
		  		}
		  		
		  		$bind_params_list[] = &$params[$key];
		  	}
		  	call_user_func_array(array($stmt, 'bind_param'), $bind_params_list);
			}
			
			$stmt->execute();
			$stmt->store_result();

			$row = array();
			$columns = array();
			$meta = $stmt->result_metadata();
			while ($column = $meta->fetch_field()) {
				$columns[] = &$row[$column->name];
			}
			call_user_func_array(array($stmt, 'bind_result'), $columns);
			               
			$results = array();
			$c = array();
			while ($stmt->fetch()) {
				$ball = $this->new_ball($table, $row);
        $results[] = $ball;
			}
			
			$stmt->free_result();
			$stmt->close(); 
			return $results;
		}
		
		public function insert($ball) {
			$fields = '';
			$values = '';
		  $params_types = '';
		  $bind_params_list = array(&$params_types);
			foreach ($ball as $field => $val) {
				$fields .= ($fields != '' ? ',' : '') .'`'. $field .'`';
				$values .= ($values != '' ? ',' : '') .'?';
				
		  	if (is_int($val)) {
		  		$params_types .= 'i';
		  	} elseif (is_string($val)) {
		  		$params_types .= 's';
		  	} elseif (is_double($val)) {
		  		$params_types .= 'd';
		  	} else {
		  		$params_types .= 'b';
		  	}
		  		
		  	$bind_params_list[] = &$ball->$field;
		  }
		  
		  $stmt = $this->con->prepare("insert into `". $ball->get_table() ."` (". $fields .") values (". $values .")");
		  call_user_func_array(array($stmt, 'bind_param'), $bind_params_list);
			return $stmt->execute();
		}
		
		public function update($ball, $conditions = '', $params = array()) {
			$update_stmt = '';
		  $params_types = '';
		  $bind_params_list = array(&$params_types);
			foreach ($ball as $field => $val) {
				$update_stmt .= ($update_stmt != '' ? ', ' : '') .'`'. $field .'` = ?';
				
		  	if (is_int($val)) {
		  		$params_types .= 'i';
		  	} elseif (is_string($val)) {
		  		$params_types .= 's';
		  	} elseif (is_double($val)) {
		  		$params_types .= 'd';
		  	} else {
		  		$params_types .= 'b';
		  	}
		  		
		  	$bind_params_list[] = &$ball->$field;
		  }
		  
		  if ($conditions == '') {
		  	$conditions = '`'. $ball->get_id_field() .'` = ?';
		  	$params = $ball->{$ball->get_id_field()};
		  }
		  
			if (!is_array($params)) {
				$params = array($params);
			}
			  
			if (count($params) > 0) {
				foreach ($params as $key => $param) {
			 		if (is_int($param)) {
			 			$params_types .= 'i';
			 		} elseif (is_string($param)) {
			 			$params_types .= 's';
			 		} elseif (is_double($param)) {
			 			$params_types .= 'd';
			 		} else {
			 			$params_types .= 'b';
			 		}
			 		
			 		$bind_params_list[] = &$params[$key];
				}
			}
			
		  $stmt = $this->con->prepare("update `". $ball->get_table() ."` set ". $update_stmt ." where ". $conditions);
		  call_user_func_array(array($stmt, 'bind_param'), $bind_params_list);
			return $stmt->execute();
		}
		
		public function delete($table, $conditions = '', $params = array()) {
			$delete_stmt = '';
		  $params_types = '';
		  $bind_params_list = array(&$params_types);
		  
			if (!is_array($params)) {
				$params = array($params);
			}
			  
			if (count($params) > 0) {
				foreach ($params as $key => $param) {
			 		if (is_int($param)) {
			 			$params_types .= 'i';
			 		} elseif (is_string($param)) {
			 			$params_types .= 's';
			 		} elseif (is_double($param)) {
			 			$params_types .= 'd';
			 		} else {
			 			$params_types .= 'b';
			 		}
			 		
			 		$bind_params_list[] = &$params[$key];
				}
			}
			
		  $stmt = $this->con->prepare("delete from `". $table ."`". ($conditions != '' ? ' where '. $conditions : ''));
		  call_user_func_array(array($stmt, 'bind_param'), $bind_params_list);
			return $stmt->execute();
		}
		
		public function delete_by_id($table, $id) {
			$table = trim($table);
			$id_field = $this->get_id_field($table);
		  $stmt = $this->con->prepare("delete from `". $table ."` where `". $id_field ."` = ?");
		  $stmt->bind_param('i', $id);
			return $stmt->execute();
		}
		
		public function delete_by_ball($ball) {
			$table = trim($ball->get_table());
			$id_field = $this->get_id_field($table);
		  $stmt = $this->con->prepare("delete from `". $table ."` where `". $id_field ."` = ?");
		  $stmt->bind_param('i', $ball->$id_field);
			return $stmt->execute();
		}
		
		public function num_rows($table, $conditions = '', $params = array()) {
			$table = trim($table);
			
		  $stmt = $this->con->prepare("select * from `". $table ."`". ($conditions != '' ? ' where '. $conditions : ''));
		  
		  if (!is_array($params)) {
		  	$params = array($params);
		  }
		  
		  if (count($params) > 0) {
		  	$params_types = '';
		  	$bind_params_list = array(&$params_types);
		  	foreach ($params as $key => $param) {
		  		if (is_int($param)) {
		  			$params_types .= 'i';
		  		} elseif (is_string($param)) {
		  			$params_types .= 's';
		  		} elseif (is_double($param)) {
		  			$params_types .= 'd';
		  		} else {
		  			$params_types .= 'b';
		  		}
		  		
		  		$bind_params_list[] = &$params[$key];
		  	}
		  	call_user_func_array(array($stmt, 'bind_param'), $bind_params_list);
			}
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows;
		}
		
		/*
			void __destruct();
			This destroys (closes) the opened connection to the MySQL database
			#return: nothing
		*/
		public function __destruct() {
			// close the opened connection
			$this->con->close();
		}
		
		
	}
	
	class DBBall {
		private $table = '';
		private $id_suffix = 'id';
		
		public function __construct($table, $obj = NULL) {
			$this->table = $table;
			if ($obj !== NULL && (is_object($obj) || is_array($obj))) {
				foreach ($obj as $attr => $val) {
					$this->$attr = $val;
				}
			}
		}
		
		public function get_table() {
			return $this->table;
		}
		
		public function get_id_field() {
			return $this->table . $this->id_suffix;
		}
		
		/*public function __get($var) {
			if (isset($this->fields[$var])) {
				return $this->fields[$var];
			} else {
				return NULL;
			}
		}*/
	}

?>