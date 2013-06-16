<?php 
	class Submission_model extends CI_Model {

		function __construct()
		{
			parent::__construct();
		}

		function get_submission($submission_id) {
			$this->load->model('like_model');
			$this->load->model('user_model');

			/* select random from all activities */
			$query = $this->db->get_where('submissions', array('id'=>$submission_id), 1);
			$result = $query->result_array();
			$submission = $result[0];
			$submission['images'] = $this->submission_model->_get_images($submission_id);
			$query = $this->db->get_where('likes', array('submission_id'=>$submission_id));
			$submission['likes'] = $query->num_rows();
			$submission['liked'] = $this->like_model->get_like($this->session->userdata('known_user'), $submission_id);
			$submission['author'] = $this->user_model->get_limited_user_data($submission['user_id']);
			return $submission;
		}

		function get_featured_submission() {  // returns activity attached
			// get latest featured submission
			$this->db->select('id');
			$this->db->order_by('id', 'desc');
			$query = $this->db->get_where('submissions',array('featured'=>1),1);
			
			$result = $query->result_array();
			$featured_submission_id = $result[0]['id'];

			$submission = self::get_submission($featured_submission_id);
			$submission['activity'] = $this->activity_model->get_activity($submission['activity_id']);

			return $submission;
		}

		function get_last_submissions($n) {  // returns activity attached
			$this->load->model('activity_model');

			// get the last $n submissions
			$this->db->select('id');
			$this->db->order_by('id', 'desc');
			$this->db->limit($n);
			$query = $this->db->get('submissions');
			
			$result = $query->result_array();
			$submissions = array();

			for ($i = 0; $i<$n; $i+=1) {
				$submissions[$i] = self::get_submission($result[$i]['id']);
				$submissions[$i]['activity'] = $this->activity_model->get_activity($submissions[0]['activity_id']);
			}

			return $submissions;
		}

		function add_submission_for($activity_id) {
			$data = array(
				'user_id' => $this->session->userdata('known_user'),
				'activity_id' => $activity_id,
				'iembed' => $this->input->post('iembed'),
				'body' => strip_tags($this->input->post('body'), '<h4><b><i>'),
				'title' => $this->input->post('title') ? $this->input->post('title') : $this->input->post('default_title')
			);
			
			$result = $this->db->insert('submissions', $data);
			if ($result) {
				// add images to submission
				$submission_id = $this->db->insert_id();

				$ids = explode(',',$this->input->post('images'));
				$this->db->where_in('id', $ids);
				$this->db->update('submission_pictures', array('submission_id'=>$submission_id));

				// increase submission count for activity
				$this->db->where(array('id' => $activity_id));
				$this->db->set('submissions','submissions+1', false);
				$this->db->update('activities');

				return $submission_id;

			}

			return false;
		}

		function update_submission($submission_id) {
			$data = array(
				'iembed' => $this->input->post('iembed'),
				'body' => strip_tags($this->input->post('body'), '<h4><b><i>')
			);
			
			$this->db->where(array('id'=>$submission_id));
			$result = $this->db->update('submissions', $data);

			if ($result) {

				// reset linked pictures
				$this->db->where(array('submission_id'=>$submission_id));
				$result = $this->db->update('submission_pictures', array('submission_id' => 0));

				// link the right pictures
				$ids = explode(',',$this->input->post('images'));
				$this->db->where_in('id', $ids);
				$this->db->update('submission_pictures', array('submission_id'=>$submission_id));

				$query = $this->db->get_where('submissions', array('id'=>$submission_id));
				$result = $query->result_array();
				return $result[0];

			}

			return false;
		}

		function add_image($url) {
			$data = array(
				'url' => $url,
				'user_id' => $this->session->userdata('known_user')
			);
			
			$result = $this->db->insert('submission_pictures', $data);
			if ($result) {
				return $this->db->insert_id();
			}

			return false;
		}

		private function _get_images($submission_id) {
			$query = $this->db->get_where('submission_pictures', array('submission_id'=>$submission_id));
			return $query->result_array();
		}
	}
?>