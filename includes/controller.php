<?php

	spl_autoload_register('customAutoload');
	require_once ROOT_PATH .'includes/configurations.php';
	//require_once ROOT_PATH .'classes/redbean.class.php';
	//require_once ROOT_PATH .'classes/viewer.class.php';
	require_once ROOT_PATH .'classes/controller.class.php';
	require_once ROOT_PATH .'classes/request.class.php';
	
	function customAutoload($class_name) {
		$controller_suffix = 'Controller';
		if (substr($class_name, -strlen($controller_suffix)) == $controller_suffix) {
			$controller_name = strtolower(str_replace($controller_suffix, '', $class_name));
			$file = ROOT_PATH .'controllers/'. $controller_name .'.controller.php';
		} else {
			$file = ROOT_PATH .'classes/'. strtolower($class_name) .'.class.php';
		}
		
		if (file_exists($file)) {
			require_once $file;
		}
	}

	$controller_class = Controller::get_controller_class();
	if (class_exists($controller_class)) {
		$ctrl = new $controller_class();
	}

?>