<?php

	class Viewer extends ClassBase {
		protected $tpl;
		
		public function __construct(/*&$parent = ''*/) {
			parent::__construct();
			$this->initialize();
		}
		
		public function initialize() {
			if (!is_object($this->tpl)) {
				$this->tpl = new SmartyConfigured;
				$post = new Post;
				$get = new Get;
				$this->tpl->assign('post', $post);
				$this->tpl->assign('get', $get);
				$this->tpl->assign('root_path', $this->parent->root);
			}
		}
		
		public function assign($var, $val) {
			$this->tpl->assign($var, $val);
		}
		
		public function display_tpl($template_name, $in_controller = true) {
			if ($in_controller) {
				$this->tpl->display($this->parent->controller .'/'. $template_name .'.html');
			} else {
				$this->tpl->display($template_name .'.html');
			}
		}
	}

?>