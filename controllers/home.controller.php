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
			
			echo '<form action method="POST"><input name="i" type="text"/><input type="submit"/></form>';

			$this->show_footer();
		}

		protected function join_action_post() {
			echo $_POST['i'];
		}
	}

?>
