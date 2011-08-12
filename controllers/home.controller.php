<?php

	class HomeController extends Controller {
		protected function __first() {
			$this->no_header_footer = true;
		}

		protected function _action() {
			$this->show_header();
			
			echo 'hello';

			$this->show_footer();
		}
		
		protected function test_action() {
			$this->show_header();
			
			echo 'test';

			$this->show_footer();
		}
	}

?>