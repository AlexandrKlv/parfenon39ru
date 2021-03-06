<?php 

class model_component_core_news extends model {
	
	public function get_component_info($component) {
		return $this->dbh->row("SELECT * FROM main WHERE component = '" . $this->dbh->escape($component) . "' LIMIT 1");
	}
	
	public function get_news($data, $params = array()) {
		$start = isset($params['count']) ? ($params['page']-1)*$params['count'] : 0;
		$sql = "";
		
		if(isset($params['join'])) {
			if($params['join'] == 'category_name') {
				$sql .= "SELECT i.*, c.name AS cat_name FROM news_items i LEFT JOIN news_categories c ON c.id = i.category_id ";
			} elseif ($params['join'] == 'category_url') {
				$sql .= "SELECT i.*, c.url AS cat_url FROM news_items i LEFT JOIN news_categories c ON c.id = i.category_id ";
			} else {
				$sql .= "SELECT * FROM news_items i ";
			}
		} else {
			$sql .= "SELECT * FROM news_items i ";
		}
		
		if(isset($params['type'])) {
			if($params['type'] == 'by_category') {
				$sql .= " WHERE i.category_id = '" . (int)$data . "'";
			} elseif($params['type'] == 'by_url') {
				$sql .= " WHERE i.url = '" . $this->dbh->escape($data) . "'";
			} elseif($params['type'] == 'by_id') {
				$sql .= " WHERE i.id = '" . (int)$data . "'";
			}
		}
		
		if(isset($params['sort'])) {
			//$sql .= " ORDER BY " . $params['sort'] . " ";
			$sql .= " ORDER BY i.date_edit DESC ";
		} else {
			$sql .= " ORDER BY i.date_edit DESC ";
		}
		
		if(isset($params['limit'])) {
			$sql .= " LIMIT " . $params['limit'] . " ";
		}
		elseif (isset($params['count'])){
			$sql .= " LIMIT " . $start . ", " . $params['count'] . " ";
		}
		
		return $this->dbh->query($sql);
	}
	
	public function get_news_item($data, $params) {
		$params['limit'] = 1;
		$result = $this->get_news($data, $params);
		if($result){
			return $result[0];
		}
		return array();
	}
	
	public function get_categories($data, $params = array()) {
		
		if(isset($params['join'])) {
			if($params['join'] == 'count_news') {
				$sql = "SELECT c.*, COUNT(i.id) AS count_news FROM news_categories c LEFT JOIN news_items i ON c.id = i.category_id ";
			} else {
				$sql = "SELECT * FROM news_categories c ";
			}
		} else {
			$sql = "SELECT * FROM news_categories c ";
		}
		
		if(isset($params['type'])) {
			if($params['type']=='by_url') {
				$sql .= " WHERE c.url = '" . $this->dbh->escape($data) . "'";
			}
		} else {
			$sql .= " WHERE c.id = '" . (int)$data . "'";
		}
		
		if(isset($params['sort'])) {
			$sql .= " ORDER BY " . $params['sort'] . " ";
		} else {
			$sql .= " ORDER BY c.id ASC ";
		}
		
		if(isset($params['limit'])) {
			$sql .= " LIMIT " . $params['limit'] . " ";
		}
		return $this->dbh->query($sql);
	}
	
	public function get_category($data, $params = array()) {
		$params['limit'] = 1;
		$result = $this->get_categories($data, $params);
		if($result){
			return $result[0];
		}
		return array();
	}
	
	//??????? ?????????? ??????? ?? url ????????? ? ?????????? ???????? ?? ????????
	public function get_count_pages($url, $count){
		if ($url!=='') { 
			$sql = "SELECT id FROM news_categories WHERE url='".$url."' LIMIT 1";
			$category_id = $this->dbh->row($sql); $category_id = $category_id['id'];
			$sql = "SELECT COUNT(*) as number FROM news_items WHERE category_id=".$category_id;
		}
		else{
			$sql = "SELECT COUNT(*) as number FROM news_items WHERE 1";		
		}
		$number = $this->dbh->row($sql); $number = $number['number'];
		return (ceil($number/$count));
	}
	
}