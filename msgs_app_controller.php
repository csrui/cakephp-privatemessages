<?php

class MsgsAppController extends AppController {
		
	var $components = array('Auth', 'Session');
	
	function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->set('title_for_layout', __('Messages', true));
		
	}
		
}

?>