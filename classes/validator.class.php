<?php

	class Validator extends ClassBase {
		protected $conditions = array();
		protected $required = false;
		protected $min_length = 0;
		protected $max_length = 0;
		protected $value;
		
		public function set_value($value) {
			$this->value = $value;
			return $this;
		}
		
		public function set_required($required = true) {
			$this->required = ($required === false ? false : true);
			return $this;
		}
		
		public function set_length($min, $max) {
			$this->set_min_length($min);
			$this->set_max_length($max);
			return $this;
		}
		
		public function set_min_length($length) {
			$this->min_length = $length;
			return $this;
		}
		
		public function set_max_length($length) {
			$this->max_length = $length;
			return $this;
		}
		
		public function add_regex($regex) {
			if ($regex == 'email') {
				$regex = '/^\b[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,6}\b$/si';
			}
			
			return $this->add_condition('regex', $regex);
		}

    public function add_filter($filter) {
			if ($filter == 'email') {
				$this->add_condition('filter', FILTER_VALIDATE_EMAIL);
			} elseif ($filter == 'number') {
				$this->add_confition('is', 'number');
			}
			return $this;
		}
		
		public function add_condition($operator, $exp) {
			$this->conditions[$operator] = $exp;
			return $this;
		}
		
		public function is_empty($value = '', $trim = true) {
			$value = ($value == '' ? $this->value : $value);
			return ($this->required ? ($trim ? trim($value) == '' : $value == '') : false);
		}
		
		public function check_length($value = '') {
			$value = ($value == '' ? $this->value : $value);
			$value_length = mb_strlen($value, 'UTF-8');
			if ($this->min_length > 0 && $value_length < $this->min_length)
				return 'short';
				
			if ($this->max_length > 0 && $value_length > $this->max_length)
				return 'long';
				
			return true;
		}
		
		public function evaluate($value = '') {
			$value = ($value == '' ? $this->value : $value);
			
			$length_status = $this->check_length($value);
			if ($length_status !== true) {
				return $length_status;
			}
			
			foreach ($this->conditions as $operator => $operand) {
				switch ($operator) {
					case 'is':
					case 'not':
						if ($operand == 'number') {
							$is = is_numeric($value);
						}
						
						if (($operator == 'is' && !$is) || ($operator == 'not' && $is)) {
							return 'invalid';
						}
						
						break;
					
					case 'regex':
						if (!preg_match($operand, $value)) {
							return 'invalid';
						}
						break;
						
					case 'filter':
						if (!filter_var($value, $operand)) {
							return 'invalid';
						}
						break;
					
					case '<>':
						$operator = '!=';
						
					case '==':
					case '===':
					case '>=':
					case '<=':
					case '<':
					case '>':
					case '!=':
					case '!==':
						eval('$cond_val = ($value '. $operator .' $operand);');
						if (!$cond_val) {
							return 'invalid';
						}
						break;
				}
			}
			
			return true;
		}
		
		public function validate($value = '') {
			$value = ($value == '' ? $this->value : $value);
			
			$is_empty = $this->is_empty($value);
			if ($is_empty === true)
				return 'empty';
				
			return $this->evaluate($value);
		}
	}

?>