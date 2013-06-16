<?php

class Widget extends CI_Controller {

	public function view($widget = false) {
		if ( !$widget || !file_exists('application/views/widget/'.$widget.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
			exit;
		}

		$this->load->view('widget/'.$widget);
	}

	// id parameter is to make url's unique
	public function disqus() { 
		self::view('disqus');
	}
}

?>