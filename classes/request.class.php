<?php

	class Post extends ClassBase {
    public function __get($var) {
        return isset($_POST[$var]) ? $_POST[$var] : null;
    }
	}
	
	class Get extends ClassBase {
    public function __get($var) {
        return isset($_GET[$var]) ? $_GET[$var] : null;
    }
	}

?>