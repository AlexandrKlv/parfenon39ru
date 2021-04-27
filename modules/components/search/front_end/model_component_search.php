<?php

	class model_component_search extends model {

		public function __construct($dbh) {
			parent::__construct($dbh);
			$this->encoding = 'UTF-8';
			$this->dbh->sqliteCreateFunction('U_LOWER', "u_strtolower", 1); // fix для невозможности использовать LOWER в sqlite
		}

		public function get_search_text($search_word, $text, $limit = 200) 
		{
			$sw_len = mb_strlen($search_word, $this->encoding);
			
			$pos = mb_stripos($text, $search_word, 0, $this->encoding);
			
			$offset = $pos + $sw_len - $limit;
			
			if ($offset < 0) {
				$start = 0;
			} else {
				$start = mb_strpos($text, '.', $offset, $this->encoding) + 1;
				if ($start > $pos) { // первая найденная точка находится после искомой строки
					$start = $sw_len;
				}
			}
			if (strlen($text) > $limit) {
				$end_pos = mb_stripos($text, ' ', $start + $limit, $this->encoding); // увеличиваем кол-во текста до первого пробела после $limit символов
			} else {
				$end_pos = $limit;
			}

			$text = mb_substr($text, 0, $end_pos, $this->encoding);
			
			return trim(mb_substr($text, $start, mb_strlen($text, $this->encoding), $this->encoding));
		}
	
		public function search_word_replace($search_word, $text) {
			$search = mb_strtolower($search_word, $this->encoding);
			$replace = '<span class="thisWord">' . $search . '</span>';
			return str_ireplace($search, $replace, $text);
		}
			
		function get_pages($parent_id = 0, $parent_url = '/', $level = 0) 
		{

			static $retval = array();
			
			$sql = "SELECT * FROM `main` WHERE parent_id = '" . (int)$parent_id . "' AND url != 'sitemap2.xml'";

			$results = $this->dbh->query($sql);

			foreach($results as $result){
				if ($result['url'] != '/') {
					$retval[] = array(
						'title' => $result['title'],
						'date_add' => $result['date_add'],
						'url'  => SITE_URL . $parent_url . $result['url']
					);

					$this->get_pages($result['id'], $parent_url . $result['url'] . '/', $level + 1);
				} else {
					$retval[] = array(
						'title' => $result['title'],
						'date_add' => $result['date_add'],
						'url'  => SITE_URL,
					);
				}
			}
			return $retval;
		}

		function get_text($parent_id = 0, $parent_url = '/', $level = 0) 
		{
			$sql = "SELECT * FROM `main` LEFT JOIN `pages` ON main.id = pages.main_id WHERE url != 'sitemap2.xml'";

			return $this->dbh->query($sql);
		}

		function divideUrl($serverName, $url)
		{	
			if (mb_strpos($url, 'http://') === 0) {
				$url = mb_substr($url, 7);
			} elseif (mb_strpos($url, 'http://www.') === 0) {
				$url = mb_substr($url, 11);
			} elseif (mb_strpos($url, 'www.') === 0) {
				$url = mb_substr($url, 4);
			}
			$replace = str_replace($serverName . '/', '', $url);
			$urlArr = explode('/', $replace);
			return $urlArr;
		}

		function full_trim($str)                            
		{                                                   
			return trim(preg_replace('/\s{2,}/', ' ', $str));
		}

		public function get_component_info($component) 
		{
			return $this->dbh->row("SELECT * FROM main WHERE component = '" . $this->dbh->escape($component) . "' LIMIT 1");
		}

	}

if (!function_exists('u_strtolower')) {
	function u_strtolower($str) {
		return mb_strtolower($str, 'UTF-8');
	}
}

?>