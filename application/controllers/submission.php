<?php

class Submission extends Extended_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('submission_model');
	}

	public function view($submission_id) {
		$submission = $this->submission_model->get_submission($submission_id);

		$this->load->model('activity_model');
		$submission['activity'] = $this->activity_model->get_activity(intval($submission['activity_id']));
		if ($submission) {
			$this->load->view('layouts/just_content', array_merge($submission, array('view'=>'submission/load')));
		}
	}

	public function load($submission_id) {
		$submission = $this->submission_model->get_submission($submission_id);

		if ($submission) {
			$this->load->view('submission/load', $submission);
		}
	}

	public function add_for($activity_id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('iembed', 'youTube', 'trim|xss_clean');
		$this->form_validation->set_rules('title', 'Titel', 'xss_clean');
		$this->form_validation->set_rules('body', 'Tekst', 'xss_clean');
		$this->form_validation->set_rules('images', 'Afbeeldingen', 'required|xss_clean');

		if($this->form_validation->run() == true) {
			$this->submission_model->add_submission_for($activity_id);
			$this->load->model('activity_model');

			$this->user_model->complete_activity($this->session->userdata('known_user'), $activity_id);

			redirect(site_url('activity/'.$this->activity_model->get_slug($activity_id)).'#submissions');
			exit;
		}

		$this->load->view('layouts/just_content', array('view'=>'submission/add', 'activity_id'=>$activity_id, 'title'=>'Inzending doen'));
	}

	// add images to the database, still have to be linked to submission later on
	public function upload_images() {

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 8096;

		$this->load->library('upload');
		$this->load->library('image_lib');

		$images = array();
		$error = false;

		$files = $_FILES;
	    $cpt = count($_FILES['userfile']['name']);
	    for($i=0; $i<$cpt; $i++) {

	        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
	        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
	        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
	        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
	        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    

		    $this->upload->initialize($config);

		    if (!$this->upload->do_upload()) {
		    	$error = $this->upload->display_errors();
		    	break;
		    } else {
		    	$data = $this->upload->data();

		    	// resize image
		    	$image_config['image_library'] = 'gd2';
                $image_config['source_image'] = './uploads/'.$data['file_name'];
                $image_config['maintain_ratio'] = TRUE;
                $image_config['width'] = 498;
                $image_config['height'] = 374;
                $this->image_lib->clear();
                $this->image_lib->initialize($image_config); 

                if (!$this->image_lib->resize()){
                	$error = $this->image_lib->display_errors();   
                	break;
              	}

		    	$id = $this->submission_model->add_image('uploads/'.$data['file_name']);
			   	array_push($images, array_merge($data, array('image_id'=>$id)));
		    }
	    }

	    if ($error) {
	    	$this->output->set_content_type('application/json');
    		$this->output->set_output(json_encode(array('error' => $error)));
	    } else {
	    	$this->output->set_content_type('application/json');
	    	$this->output->set_output(json_encode(array('images' => $images)));
	    }
		
	}

	public function edit($submission_id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('iembed', 'youTube', 'trim|xss_clean');
		$this->form_validation->set_rules('body', 'Tekst', 'xss_clean');
		$this->form_validation->set_rules('images', 'Afbeeldingen', 'required|xss_clean');

		if($this->form_validation->run() == true) {
			$submission = $this->submission_model->update_submission($submission_id);
			$this->load->model('activity_model');
			redirect('activity/'.$this->activity_model->get_slug($submission['activity_id']));
			exit;
		}

		$submission = $this->submission_model->get_submission($submission_id);

		$this->load->view('layouts/just_content', array_merge($submission, array('view'=>'submission/edit', 'title'=>'Inzending bewerken')));
	}

	public function remove($submission_id) {
		// delayed
	}

}

?>