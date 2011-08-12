<?php

	class ClassBase {
		protected $parent;
		
		public function __construct(/*&$parent = ''*/) {
			//$this->parent = $trace[1]['object'];
			//print_r($trace[1]['object']);
			//echo '<br><br>';
			//if ($parent != '') {
			//	$this->parent = &$parent;
			//}
			$trace = debug_backtrace();
			if (isset($trace[2]) && isset($trace[2]['object']) && is_object($trace[2]['object'])) {
				$this->parent = $trace[2]['object'];
			} elseif (isset($trace[1]) && isset($trace[1]['object']) && is_object($trace[1]['object'])) {
				$this->parent = $trace[1]['object'];
			}
		}
		
		public function __get($var) {
			if (isset($this->$var)) {
				return $this->$var;
			} elseif (isset($this->parent->$var) || is_object($this->parent->$var)) {
				return $this->parent->$var;
			}
		}
		
		public function __call($func, $args) {
			if (method_exists($this, $func)) {
				//return $this->$var();
				return call_user_func_array($this->$func, $args);
			} elseif (method_exists($this->parent, $func)) {
				//return $this->parent->$var();
				return call_user_func_array($this->parent->$func, $args);
			}
		}
	}

?>