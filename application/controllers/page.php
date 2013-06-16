<?php

class Page extends Extended_Controller {

	public function home()
	{
		$this->load->model('submission_model');
		$this->load->model('activity_model');
		$this->load->model('user_model');

		$data = array();

		if ($this->session->userdata('logged_in')) {
			$data['featured_submission'] = $this->submission_model->get_featured_submission();
			$data['latest_submissions'] = $this->submission_model->get_last_submissions(3);
			$data['top_players'] = $this->user_model->get_top_users(3);
			$data['ranking'] = $this->user_model->get_ranking();
			$data['latest_activities'] = $this->activity_model->get_latest_activities(5);
			$data['view'] = 'page/home';
		} else {
			$data['top_players'] = $this->user_model->get_top_users(3);
			$data['latest_activities'] = $this->activity_model->get_latest_activities(3);
			$data['latest_submissions'] = $this->submission_model->get_last_submissions(3);
			$data['view'] = 'page/home_logged_out';
		}

		$this->load->view('layouts/main', $data);
	}

	public function ranking()
	{
		$this->load->model('activity_model');
		$this->load->model('user_model');

		$data = array();

		if ($this->session->userdata('logged_in')) {
			$data['top_players'] = $this->user_model->get_top_users(5);
			$data['ranking'] = $this->user_model->get_ranking();
			$data['achievements'] = $this->activity_model->get_achievements();
			$data['view'] = 'page/ranking';
			$data['ranked_user'] = $this->user_model->get_full_user_data($this->session->userdata('known_user')); // get full user data
			$data['submissions'] = $this->user_model->get_submissions($this->session->userdata('known_user')); // pass view for layout
		} else {
			redirect(site_url(''));
		}

		$this->load->view('layouts/main', $data);
	}

	public function view($page = 'start')
	{
		if ( ! file_exists('application/views/page/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}

		$this->load->view('layouts/main', array('view'=>'page/'.$page));
	}

	public function embed($page = 'home') {
		if ( ! file_exists('application/views/page/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}

		$this->load->view('layouts/main', array('view'=>'page/'.$page));
	}

	public function canvas() {

		if ($this->input->get('action') == 'invite') {

			$this->load->model('activity_model');
			$data = $this->activity_model->get_activity($this->input->get('activity'));
			$data['load']['activity_styles'] = true; // pass true to load activity specific styles

			$this->load->view('templates/header', $data);
			$this->load->view('page/canvas_invite');
			$this->load->view('templates/footer');

		} else {
			self::start();
		}
	}

	public function start($ref = 'browser') {
		$this->load->model('user_model');
		$this->user_model->log($ref);

		$this->load->model('activity_model');
		$activity = $this->activity_model->get_random_activity();
		redirect(site_url('activity/'.$activity['slug']));
	}

	public function destroy_session() {
		$this->session->sess_destroy();
		$this->load->view('templates/header');
		$this->load->view('page/destroy_session', $this->session->all_userdata());
		$this->load->view('templates/footer');
	}

	public function reset() {
		
		$this->db->truncate('submissions');
		$this->db->truncate('submission_pictures');
		$this->db->truncate('queues');
		$this->db->truncate('achievements_for_user');
		$this->db->update('users', array('points'=>0, 'level'=>1));

		redirect(site_url('start'));
	}
}

?>