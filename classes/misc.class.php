<?php

	class Misc extends ClassBase {
		public function redirect($url) {
			header('Location: '. $url);
			exit();
		}
		
		public function is_empty($var) {
			if (is_array($var)) {
				foreach ($var as $key => $val) {
					if ($this->is_empty($val)) {
						return $key;
					}
				}
				
				return false;
			} else {
				if (trim($var) == '') {
					return true;
				} else {
					return false;
				}
			}
		}
		
		public function request_array($arr, $request_type = 'post') {
			if (!is_array($arr)) $arr = array($arr);
		
			$new_arr = array();
			foreach ($arr as $val) {
				if ($request_type == 'get') {
					$new_arr[$val] = $_GET[$val];
				} else {
					$new_arr[$val] = $_POST[$val];
				}
			}
			
			return $new_arr;
		}
	
		public function rand_code($length, $charstype = 'all', $encryption = 'none') {
			$chars = '';
			if ($charstype == 'all') {
				$charstype = array('lower', 'upper', 'num', 'symbol');
			} elseif (is_string($charstype)) {
				$charstype = array($charstype);
			}
			
			if (in_array('lower', $charstype)) {
				$chars .= 'abcdefghijklmnopqrstuvwxyz';
			}
			
			if (in_array('upper', $charstype)) {
				$chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			}
			
			if (in_array('num', $charstype)) {
				$chars .= '0123456789';
			}
			
			if (in_array('symbol', $charstype)) {
				$chars .= '!@#$%^&*()_+=-';
			}
			
			$code = '';
			$chars_len = strlen($chars);
			for ($i = 0; $i < $length; $i++) {
				$code .= $chars[rand(0 , $chars_len - 1)];
			}
			
			return ($encryption == 'md5' ? md5($code) : ($encryption == 'sha1' ? sha1($code) : $code));
		}
		
		public function mail($to, $subject, $message, $from = '', $html = true, $charset = 'utf-8') {
			$headers = ($from != '' ? 'From: '. $from ."\r\n".'Reply-To: '. $from ."\r\n" : '') .
								($html ? 'Content-Type: text/html; charset='. $charset ."\r\n" : '');
			return mail($to, $subject, $message, $headers);
		}
	}

?>