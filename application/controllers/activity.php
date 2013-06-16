<?php

class Activity extends Extended_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('activity_model');
	}

	public function view($activity_slug = 'random')
	{

		if (!file_exists('application/views/activity/view.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if ($activity_slug == 'random') {
			$data = $this->activity_model->get_random_activity();
		} else {
			$data = $this->activity_model->get_activity($activity_slug);
		}

		$data['load']['activity_styles'] = true; // pass true to load activity specific styles
		$data['load']['disqus']['comment_count'] = false; // pass true when disqus comment counts need to be available
		
		$this->load->view('layouts/activity', $data);
	}

	public function index() {
		$_data = $this->activity_model->get_latest_activities(999);
		$data = array();
		if ($q = $this->input->post('query')) {
			foreach ($_data as $_activity) {
				if (fnmatch('*'.strtolower($q).'*', strtolower($_activity['interests'].$_activity['title']))) {
					array_push($data, $_activity);
				}
			}
		} else {
			$data = $_data;
		}

		$this->load->view('layouts/main', array('activities'=>$data, 'view'=>'activity/index'));
	}
}

?>