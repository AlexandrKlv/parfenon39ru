<?php 

class controller_block_slider extends block {

	public function action_index($block) {
		$results = $this->get_slides($block['id']);
		
		if(!$results) {
			return array();
		}
		$this->data['slides'] = array();
		foreach($results as $result) {
			$this->data['slides'][] = array(
				'id' => $result['id'],
				'image' => SITE_URL . '/uploads/images/slider/' . $result['image'],
				'text' => $result['text']
			);
		}
		
		$settings = unserialize($block['params']);
		
		if($settings['auto']) {
			$settings['auto'] = 'true';
		} else {
			$settings['auto'] = 'false';
		}
		$this->data['module_id'] = $block['id'];

		$this->page['head']  = '<!-- START slider -->' . "\n\t";
		$this->page['head'] .= $this->add_js_file (SITE_URL . '/modules/blocks/' . $block['module_dir'] . '/source/js/jflow.plus.js') ;
		$this->page['head'] .= $this->add_css_file (SITE_URL . '/modules/blocks/' . $block['module_dir'] . '/source/css/jflow.style.css') ;
		$this->page['head'] .= $this->add_js ('
			$(document).ready(function(){
				$("#myController' . $block['id'] . '").jFlow({
					controller: ".jFlowControl", // must be class, use . sign
					slideWrapper : "#jFlowSlider' . $block['id'] . '", // must be id, use # sign
					slides: "#mySlides' . $block['id'] . '",  // the div where all your sliding divs are nested in
					selectedWrapper: "jFlowSelected",  // just pure text, no sign
					width: "' . (int)$settings['width'] . 'px",  // this is the width for the content-slider
					height: "' . (int)$settings['height'] . 'px",  // this is the height for the content-slider
					duration: ' . (int)$settings['duration'] . ',  // time in miliseconds to transition one slide
					interval: ' . (int)$settings['interval'] . ', 
					prev: ".jFlowPrev", // must be class, use . sign
					next: ".jFlowNext", // must be class, use . sign
					auto: ' . $settings['auto'] . '
				});
			});
		') ;
		
		$this->page['head']  .= '<!-- END slider -->' ;
		
		$this->page['html'] = $this->load_view('slider');
		return $this->page;
	}
	
	public function action_activate() {
		$page = array();
		if(isset($_POST['activate'])) {
			$params= array(
				'width' => (int)$_POST['width'],
				'height' => (int)$_POST['height'],
				'interval' => (int)$_POST['interval'],
				'duration' => (int)$_POST['duration'],
				'auto' => isset($_POST['auto']) ? 1 : 0
			);

			$page['params'] = serialize($params);
		}
		
		$page['html'] = $this->load_view('activate');
		
		return $page;
	}
	
	public function action_deactivate($info) {
		
	}
	
	public function action_settings($info) {
		$page = array();
		$this->data['settings'] = unserialize($info['params']);

		if(isset($_POST['edit_settings'])) {
		
			if(isset($this->url['params']['edit_slide'])) {
			
				$data = array(
					'id' => $this->url['params']['edit_slide'],
					'text' => $_POST['slide_text'],
					'sort' => $_POST['slide_sort']
				);
				$this->edit_slide($data);
				
			} elseif(isset($_FILES['slide_img']) && is_uploaded_file($_FILES['slide_img']['tmp_name'])) {
			
				$this->load_helper('image');
				$img_path = ROOT_DIR . '/uploads/images/slider/';
				$data = array(
					'module_id' => $this->url['actions'][1],
					'text' => $_POST['slide_text'],
					'sort' => $_POST['slide_sort'],
					'image' => $this->helper_image->img_upload('slide_img', $this->data['settings']['width'], $img_path, 0, 'auto', $this->data['settings']['height'])
				);
				$this->add_slide($data);
			}
			
			$params= array(
				'width' => (int)$_POST['width'],
				'height' => (int)$_POST['height'],
				'interval' => (int)$_POST['interval'],
				'duration' => (int)$_POST['duration'],
				'auto' => isset($_POST['auto']) ? 1 : 0
			);

			$page['params'] = serialize($params);
		
		}
		
		if(isset($this->url['params']['del_slide'])) {
			$result = $this->get_slide($this->url['params']['del_slide']);
			@unlink(ROOT_DIR . '/uploads/images/slider/' .$result['image']);
			$this->delete_slide($this->url['params']['del_slide']);
		}
		
		$this->data['active_module_id'] = $info['id'];
		
		if(isset($this->url['params']['edit_slide'])) {
			$slide = $this->get_slide($this->url['params']['edit_slide']);
			$this->data['edit_slide'] = array(
				'id' => $slide['id'],
				'image' => $slide['image'],
				'src' => SITE_URL . '/uploads/images/slider/' . $slide['image'],
				'text' => $slide['text'],
				'sort' => (int)$slide['sort']
			);
		} else {
			$this->data['edit_slide'] = false;
			$this->data['slides'] = array();
			$results = $this->get_slides($info['id']);
			foreach($results as $result) {
				$this->data['slides'][] = array(
					'id' => $result['id'],
					'image' => $result['image'],
					'src' => SITE_URL . '/uploads/images/slider/' . $result['image'],
					'text' => $result['text'],
					'sort' => (int)$result['sort']
				);
			}
		}
		
		$page['html'] = $this->load_view('settings');
		return $page;
	}
	
	/* 
	* model 
	*/
	
	protected function get_slides($module_id) {
		$sql = "SELECT * FROM slider WHERE module_id = '" . (int)$module_id . "' ORDER BY sort ASC";
		return $this->dbh->query($sql);
	}
	
	protected function get_slide($id) {
		$sql = "SELECT * FROM slider WHERE id = '" . (int)$id . "'";
		return $this->dbh->row($sql);
	}
	
	protected function add_slide($data) {
		$sql = "INSERT INTO slider ( module_id, image, text, sort, date_add ) 
						VALUES (
							'" . $data['module_id'] . "',
							'" . $data['image'] . "',
							'" . $data['text'] . "',
							'" . $data['sort'] . "',
							'" . time() . "'
						)";
		return $this->dbh->exec($sql);
	}
	
	protected function edit_slide($data) {
		$sql = "UPDATE slider SET
							text = '" . $this->dbh->escape($data['text']) . "',
							sort = '" . (int)$data['sort'] . "'
						WHERE id = '" . (int)$data['id'] . "'";
		return $this->dbh->exec($sql);
	}
	
	protected function delete_slide($id) {
		$sql = "DELETE FROM slider WHERE id = '" . (int)$id . "'";
		return $this->dbh->exec($sql);
	}
}

 ?>