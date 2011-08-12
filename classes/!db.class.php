<?php

	class DB extends ClassBase {
		public function store($obj) {
			try {
				$store_result = $this->rb->store($obj);
			} catch (Exception $e) {
				$error_msg = $e->getMessage();
				if (stristr($error_msg, 'Duplicate entry') !== false) {
					$msg_parts = explode('for key \'', $error_msg);
					$msg_parts = explode('\'', $msg_parts[1]);
					$field_name = $msg_parts[0];
					return array(
						'status' => 'exists',
						'field' => $field_name
					);
				}
			}
			
			return ($store_result ? array('status' => 'stored', 'id' => $store_result) : $store_result);
		}
		
		public function __call($f,$a){
			if (method_exists('R', $f)) {
				return call_user_func_array("R::$f", $a);
			}
		
			if (method_exists($this->rb, $f)) {
				return call_user_func_array(array($this->rb, $f), $a);
			}
		}
	}

?>