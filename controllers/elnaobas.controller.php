<?php

	class ElnaobasController extends Controller {
		protected function __first() {
			$this->no_header_footer = true;
		}
		
		protected function show_header() {
			$this->viewer->display_tpl('header');
		}
		
		protected function show_footer() {
			$this->viewer->display_tpl('footer');
		}
		
		/*
			Subjects Administration
			All actions that are responsible for subjects administration!
		*/
		protected function subject_show_action() {
			$bid = intval($_GET['bid']);
			$this->show_header();
			
			$branches = $this->db->select('subject', '`branchid` = ?', $bid);
			
			$this->viewer->assign('branches', $branches);
			$this->viewer->display_tpl('branch/show');
			
			$this->show_footer();
		}
		
		/*
			Branches Administration
			All actions that are responsible for branches administration!
		*/
		protected function branch_new_action_post() {
			$fields_titles = array(
				'branchtitle' => 'اسم الفرع'
			);
		
			$data = $this->misc->request_array('branchtitle');
			if (($empty_field = $this->misc->is_empty($data)) === false) {
				$ball = $this->db->new_ball('branch');
				$ball->branchtitle = $data['branchtitle'];
				if ($this->db->insert($ball)) {
					$this->misc->redirect('show');
				} else {
					$this->show_header();
					echo 'مش زابط، جرب بعدين!';
					$this->show_footer();
				}
			} else {
				$this->show_header();
				echo 'حضرتك تارك '. $fields_titles[$empty_field] .' فاضي وبدك تكمل؟!';
				$this->show_footer();
			}

			$this->do_action = false;
		}

		protected function branch_new_action() {
			$this->show_header();
			
			$this->viewer->display_tpl('branch/new');
			
			$this->show_footer();
		}
		
		protected function branch_edit_action_post() {
			$bid = intval($_GET['bid']);
			
			$fields_titles = array(
				'branchtitle' => 'اسم الفرع'
			);
		
			$data = $this->misc->request_array('branchtitle');
			if (($empty_field = $this->misc->is_empty($data)) === false) {
				$ball = $this->db->select_by_id('branch', $bid);
				$ball->branchtitle = $data['branchtitle'];
				if ($this->db->update($ball)) {
					$this->misc->redirect('../show');
				} else {
					$this->show_header();
					echo 'مش زابط، جرب بعدين!';
					$this->show_footer();
				}
			} else {
				$this->show_header();
				echo 'حضرتك تارك '. $fields_titles[$empty_field] .' فاضي وبدك تكمل؟!';
				$this->show_footer();
			}

			$this->do_action = false;
		}
		
		protected function branch_edit_action() {
			$bid = intval($_GET['bid']);
			$this->show_header();

      $branch = $this->db->select_by_id('branch', $bid);
			$this->viewer->assign('branch', $branch);
			$this->viewer->display_tpl('branch/edit');
			
			$this->show_footer();
		}
		
		protected function branch_delete_action_post() {
			$bid = intval($_GET['bid']);
			$this->show_header();
			
			$this->db->delete_by_id('branch', $bid);
			$teachers = $this->db->select('teacher', '`branchid` = ?', $bid);
			foreach ($teachers as $teacher) {
				$this->db->delete('booklet', '`teacherid` = ?', $teacher->teacherid);
				$this->db->delete_by_ball($teacher);
			}
			
			$subjects = $this->db->select('subject', '`branchid` = ?', $bid);
			foreach ($subjects as $subject) {
				$this->db->delete('booklet', '`subjectid` = ?', $subject->subjectid);
				$this->db->delete_by_ball($subject);
			}
			
			echo 'خلص شطبنالك إللي بدك اياه!';
			
			$this->show_footer();
			
			$this->do_action = false;
		}
		
		protected function branch_delete_action() {
			$bid = intval($_GET['bid']);
			$this->show_header();
			
			$this->viewer->display_tpl('delete_confirmation');
			
			$this->show_footer();
		}
		
		protected function branch_show_action() {
			$this->show_header();
			
			$branches = $this->db->select_query('select * from `branch` left join (select count(subjectid) as `subjects_num`, `branchid` as `bid` from `subject` group by `branchid`)`s` on `s`.`bid` = `branch`.`branchid` left join (select count(subjectid) as `teachers_num`, `branchid` as `bid` from `teacher` group by `branchid`)`f` on `f`.`bid` = `branch`.`branchid`');
			
			$this->viewer->assign('branches', $branches);
			$this->viewer->display_tpl('branch/show');
			
			$this->show_footer();
		}
		
		protected function _action() {
			$this->show_header();
			
			$this->viewer->display_tpl('main');
			$this->show_footer();
		}
	}

?>