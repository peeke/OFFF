<?php

class User extends Extended_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('activity_model');
	}

	public function view($id = -1) {

		$id = $id == -1 ? $this->session->userdata('logged_in_user') : $id;

		// check whether view exists
		if (!$this->user_model->user_exists($id)) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Naam', 'trim|xss_clean');
		if ($this->input->post('password') != '') { $this->form_validation->set_rules('password', 'Wachtwoord', 'matches[password_check]'); }
		if ($this->input->post('password') != '') { $this->form_validation->set_rules('password_check', 'Wachtwoord validatie', 'required'); }
		$this->form_validation->set_rules('age', 'Leeftijd', 'integer');

		if($this->form_validation->run() == true) {
			$this->user_model->update_userdata();
		}

		$this->load->view('layouts/main', array_merge(
			$this->user_model->get_full_user_data($id), // get full user data
			array('view'=>'user/profile', 'submissions'=>$this->user_model->get_submissions($id)) // pass view for layout
		));
	}

	public function upgrade() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Naam', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Wachtwoord', 'trim|required|xss_clean');
		$this->form_validation->set_rules('age', 'Leeftijd', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->load->view('layouts/main', array('view'=>'user/upgrade'));
		} else {
			$this->user_model->upgrade_limited_user();
			redirect(site_url(''));
		}
		
	}

	public function confirm_user($key) {
		if ($this->user_model->confirm_user($key)) {
			redirect('page/confirm_success');
		} else {
			redirect('page/confirm_failed');
		}
	}

	public function login() {
		// This method will have the credentials validation
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			// Field validation failed.  User redirected to login page
			$this->load->view('layouts/main', array('view'=>'user/login'));
		} else {
			// Go to private area
			if ($this->user_model->login()) {
				if ($this->input->post('ref') == site_url('user/login')) {
					redirect(site_url(''));
					return false;
				}
				redirect($this->input->post('ref'));

			} else {
				redirect(site_url('user/login'));
			}			
		}
	}

	public function logout() {
		$this->user_model->logout();
		redirect($this->input->post('ref'));
	}

	// add images to the database, still have to be linked to submission later on
	public function update_avatar() {

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 8096;

		$this->load->library('upload');

		$images = array();
		$error = false; 

		$this->upload->initialize($config);

		if (!$this->upload->do_upload()) {
			$error = $this->upload->display_errors();
		} else {
			$data = $this->upload->data();
			$this->load->library('image_lib');

			// resize image
			$image_config['image_library'] = 'gd2';
			$image_config['source_image'] = './uploads/'.$data['file_name'];
			$image_config['maintain_ratio'] = TRUE;
			$s = getimagesize('./uploads/'.$data['file_name']);
			if ($s[0]>$s[1]) {
				$image_config['height'] = 200;
				$image_config['width'] = $s[0]/$s[1]*200;
			} else {
				$image_config['width'] = 200;
				$image_config['height'] = $s[1]/$s[0]*200;
			}
			$this->image_lib->clear();
			$this->image_lib->initialize($image_config); 

			if (!$this->image_lib->resize()){
				$error = $this->image_lib->display_errors();   
			}

			// crop image
			$image_config['image_library'] = 'gd2';
			$image_config['source_image'] = './uploads/'.$data['file_name'];
			$s = getimagesize('./uploads/'.$data['file_name']);
			$image_config['x_axis'] = ($s[0]-200)/2;
			$image_config['y_axis'] = ($s[1]-200)/2;
			$image_config['maintain_ratio'] = FALSE;
			$image_config['width'] = 200;
			$image_config['height'] = 200;
			$this->image_lib->clear();
			$this->image_lib->initialize($image_config); 

			if (!$this->image_lib->crop()){
				$error = $this->image_lib->display_errors();   
			}

			$id = $this->user_model->update_avatar('uploads/'.$data['file_name']);
		}

		if ($error) {
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('error' => $error)));
		} else {
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('avatar' => 'uploads/'.$data['file_name'])));
		}
		
	}
}

?>