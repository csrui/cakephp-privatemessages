<?php

class MsgsAppController extends AppController {
		
	function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->set('title_for_layout', __('Messages', true));
		
	}
		
}

?>