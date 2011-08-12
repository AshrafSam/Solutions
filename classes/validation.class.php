<?php

	class Validation extends ClassBase {
		protected $validators = array();
		
		public function add($name, $validator, $field = '') {
			$this->validators[($field == '' ? $name : $field)] = array('value' => $name, 'validator' => $validator);
		}
		
		public function validate($method = 'POST') {
			$method = strtoupper(trim($method));
			if ($method == 'POST' || $method == 'GET') $data_array = ($method == 'POST' ? $_POST : $_GET);
			foreach ($this->validators as $field => $contents) {
				if ($contents['validator']->is_empty(($method == 'VALUES' ? $contents['value'] : $data_array[$contents['value']]))) {
					return array(
						'status' => 'empty',
						'field' => $field
					);
				}
			}
			
			foreach ($this->validators as $field => $contents) {
				if (($status = $contents['validator']->evaluate(($method == 'VALUES' ? $contents['value'] : $data_array[$contents['value']]))) !== true) {
					return array(
						'status' => $status,
						'field' => $field
					);
				}
			}
			
			return array(
				'status' => 'valid'
			);
		}
	}

?>