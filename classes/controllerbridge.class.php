<?php

	Abstract class ControllerBridge {
		private $objs = array();
    
		public function addObj(&$object, $object_name = '') {
			$object_name = ($object_name == '' ? strtolower(get_class($object)) : $object_name);
			$this->objs[$object_name] = &$object;
		}
    
		public function __get($var) {
			if (isset($this->$var)) {
				return $this->$var;
			} elseif (isset($this->objs[$var])) {
				return $this->objs[$var];
			} else {
				return NULL;
			}
		}
	}

?>