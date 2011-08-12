<?php

require_once ROOT_PATH .'includes/smarty/Smarty.class.php';

class SmartyConfigured extends Smarty {

   function __construct() {

        parent::__construct();

				$this->template_dir = ROOT_PATH .'style/templates/';
				$this->compile_dir = ROOT_PATH .'includes/smarty/compiled/';

        //$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
   }

}
?>