<?php

	class ElnaobasController extends Controller {
		protected function __first() {
			$this->no_header_footer = true;
		}

		protected function _action() {
			$this->show_header();
echo 'a';			
			//$nearby_protests = $this->protest->get_nearby_protests();
			//$this->viewer->assign('nearby_protests', $nearby_protests);
			$results = $this->db->select('branch', 'branchid > ?', 1);
			foreach ($results as $ball) {
				echo $ball->branchid .': '. $ball->branchtitle;
				echo "<BR>";
			}
			
			//$nearby_protests = $this->protest->FAKE_get_nearby_protests();
			//$this->viewer->assign('nearby_protests', $nearby_protests);
			
			//$this->viewer->display_tpl('main');
			$this->show_footer();
		}
	}

?>