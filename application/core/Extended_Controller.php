<?php 

class Extended_Controller extends CI_Controller {

	public $user = null;

	function __construct()
	{
		parent::__construct();

		$user = $this->user_model->get_current_user_data();

		$queues = $this->user_model->get_queues_for_user($user['id']);
		
		$points = $user['points'];
		foreach($queues as $_queue) {
			$points -= $_queue['value'];
		}
		if ($points < 0) { $points = 0; }
		$user['progress_bar_start'] = ($points/($user['level']*11-6))*100;

		if (isset($user['user_group'])) { 
			$this->session->set_userdata(array('user_group'=>$user['user_group']));
		}

		$this->load->vars(array('user'=>$user));
		$this->load->vars(array('queues'=>$queues));
	}
}

?>