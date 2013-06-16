<?php 

class Like extends Extended_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('like_model');
	}

	public function set($submission_id)
	{

		$this->like_model->set_like($this->session->userdata('logged_in_user'), $submission_id);
	}
}

?>