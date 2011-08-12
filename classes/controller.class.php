<?php

	class Controller extends ControllerBridge {
		static protected $route_redirect = array();
		protected $action = '';
		protected $query_string = '';
		protected $query_array = '';
		protected $controllers_string = '';
		protected $controllers = array();
		protected $controller = '';
		protected $do_action = true;
		protected $logged_user = 0;
		protected $root = '';
		protected $this_link = '';
		protected $no_header_footer = false;
		
		public function __construct() {
			global $dbinfo;
			
			$viewer = new Viewer;
			$db = new DB($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['name']);
			$misc = new Misc;
			$country = new Country;
			$user = new User;
			
			//R::setup('mysql:host='. $dbinfo['host'] .';dbname='. $dbinfo['name'], $dbinfo['user'], $dbinfo['pass']);
			///R::$writer->tableFormatter = new RedBeanFormatter;
			//$rb = R::$redbean;
			//$rb->freeze(true);
			
			$this->addObj($rb, 'rb');
			$this->addObj($db, 'db');
			$this->addObj($misc, 'misc');
			$this->addObj($viewer, 'viewer');
			$this->addObj($country, 'country');
			$this->addObj($user, 'user');
			
			if (method_exists($this, '__first')) {
				$this->__first();
			}
			
			$this->logged_user = $user->logged_user();
			$this->viewer->assign('logged_user', $this->logged_user);
			
			$this->controller = self::get_controller_name();
			$this->viewer->assign('controller', $this->controller);
			
			$this->initialize();                    
			$this->do_action();
		}
		
		static public function add_route_redirect($route, $redirect) {
			self::$route_redirect[$route] = $redirect;
		}
		
		static public function get_controllers_string() {
			$controller = (isset($_GET['url']) ? $_GET['url'] : 'home/');
			
			if (isset(self::$route_redirect[$controller])) {
				$controller = self::$route_redirect[$controller];
			}
			
			$controller = (substr($controller, -1) == '/' ? substr($controller, 0, strlen($controller) - 1) : $controller);
			return $controller;
		}
		
		static public function get_all_controllers() {
			$controller = self::get_controllers_string();
			$controller_parts = explode('/', $controller);
			return $controller_parts;
		}
		
		static public function get_controller_class() {
			$controller_parts = self::get_all_controllers();
			$controller_class = $controller_parts[0] . 'Controller';
			$controller_class[0] = strtoupper($controller_class[0]);
			return $controller_class;
		}
		
		static public function get_controller_name($lowercase = true) {
			$controller_parts = self::get_all_controllers();
			if ($lowercase) {
				return strtolower($controller_parts[0]);
			} else {
				return $controller_parts[0];
			}
		}		
		
		protected function initialize() {
			$this->controllers_string = self::get_controllers_string();
			
			$all_controllers = self::get_all_controllers();
			$this->controller = $all_controllers[0];
			$this->controllers = array_slice($all_controllers, 1);
			if (isset($this->controllers[0])) {
				$this->action = $this->controllers[0];
			}
			
			$query_string = preg_replace('/^url=(.*)(&|$)/Usi', '', $_SERVER['QUERY_STRING']);
			$this->query_string = $query_string;
			parse_str($query_string, $this->query_array);
			
			$path_parts = explode('/', $_SERVER['SCRIPT_NAME']);
			$folder_path = implode('/', array_slice($path_parts, 0, count($path_parts) - 1));
			$this->root = 'http://'. $_SERVER['SERVER_NAME'] . $folder_path .'/';
			$this->this_link = $this->root . $this->controllers_string . ($query_string != '' ? '/?'. $query_string : '');
			$this->viewer->assign('root_path', $this->root);
		}
		
		protected function do_action() {
			$actions = $this->controllers;
			$actions_num = count($actions);
		
			$last_action = '';
			$posted = false;
			$loaded = false;
			for ($i = $actions_num; $i >= 0; $i--) {
				$action = implode('_', array_slice($actions, 0, $i));
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$action_post_function = $action .'_action_post';
					if (method_exists($this, $action_post_function)) {
						$this->$action_post_function();
						$posted = true;
					}
				} else {
					$posted = true;
				}

				if ($this->do_action) {
					$action_function = $action .'_action';
					if (method_exists($this, $action_function)) {
							if (!$this->no_header_footer) {
								$this->show_header();
							}
							
							$this->$action_function();
							$loaded = true;
							
							if (!$this->no_header_footer) {
								$this->show_footer();
							}
					}
				} else {
      		$loaded = true;
      	}
      	
	      if ($loaded || $posted) {
	      	break;
	      }
      }
		}
		
		protected function show_header() {
			$this->viewer->display_tpl('header', false);
		}
		
		protected function show_footer() {
			$this->viewer->display_tpl('footer', false);
		}
	}

?>