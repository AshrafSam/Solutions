<?php

	class Country extends ClassBase {
		public function get_countries() {
			return $this->db->Find('country', '1');
		}
		
		public function get_country_by_code($countrycode) {
			$countries = $this->db->Find('country', "`countrycode` = '". $countrycode ."'");
			if (count($countries) == 1) {
				return current($countries);
			} else {
				return false;
			}
		}
		
		public function get_user_country_code() {
			global $dbinfo;
			$ip2c = new ip2country();
			$ip2c->mysql_host = $dbinfo['host'];
			$ip2c->db_user = $dbinfo['user'];
			$ip2c->db_pass = $dbinfo['pass'];
			$ip2c->db_name = $dbinfo['name'];
			$ip2c->table_name = 'country_ip';
			if ($ip2c->get_ip_num() == 0) {
				return $ip2c->get_country_code('92.253.3.145');
			} else {
				return $ip2c->get_country_code();
			}
		}
	}

?>