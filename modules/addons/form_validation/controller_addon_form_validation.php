<?php 
class controller_addon_form_validation extends addon {
	public function action_index($addon) {
		$this->page['head'] = $this->add_js_file(SITE_URL . '/modules/addons/' . $this->addon_name . '/jquery.validate.min.js');
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/modules/addons/' . $this->addon_name . '/script.js');
		
		return $this->page;
	}
}