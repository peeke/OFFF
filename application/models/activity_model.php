<?php 
	class Activity_model extends CI_Model {

	    function __construct()
	    {
	        parent::__construct();
	    }

	    function get_activity($slug_or_id) {
			/* select random from all activities */
			$activity = self::_get_activity($slug_or_id);

			$this->db->from('activities');
			$this->db->where_in('id',explode(',', $activity['successor_of']));
			$query = $this->db->get();

			$activity['related'] = $query->result_array();

			return $activity;
	    }

	    function get_slug($id) {
	    	$this->db->select('slug');
	    	$query = $this->db->get_where('activities', array('id'=>$id), 1);
	    	$result = $query->result_array();
	    	return $result[0]['slug'];
	    }

	    function get_random_activity() {
	    	/* select random from all activities */
	    	$g = $this->session->userdata('user_group');
	    	if ($g == 0) {
		    	$query = $this->db->get('activities');
				$result = $query->result_array();
				$activity = $result[rand(0,count($result)-1)];
			} else if ($g == 1) {
				$activity = self::get_biased_activity();
			} else if ($g == 2) {
				$activity = self::get_online_offline_activity();
			}

			// enrich activity
			$activity['player_count'] = explode(',', $activity['player_count']);
			$activity['ingredients'] = explode(',', $activity['ingredients']);
			
			/* join matching submissions */
			$submissions = self::_get_submissions($activity['id']);
			$activity['submissions'] = $submissions;
			
			return $activity;
	    }

	    function get_biased_activity() {
	    	$this->load->model('user_model');
	    	$user = $this->user_model->get_limited_user_data($this->session->userdata('known_user'));
	    	
	    	$interests = explode(',', $user['interests']);

	    	$this->db->from('activities');
	    	$i = 0;
	    	$this->db->like('interests', str_replace(',','',$interests[$i]));
	    	while (isset($interests[$i+1])) {
	    		$i+=1;
	    		$this->db->or_like('interests', str_replace(',','',$interests[$i]));
	    	}
	    	$query = $this->db->get();
	    	if ($query->num_rows() && rand(0,1)==1) {
				$result = $query->result_array();
				$activity = $result[rand(0,count($result)-1)];
			} else {
				$query = $this->db->get('activities');
				$result = $query->result_array();
				$activity = $result[rand(0,count($result)-1)];
			}
			return $activity;
	    }

	    function get_popular_activities($n) {
			// get pupular activities
				
			$this->db->order_by('submissions','desc');
			if ($n > 0) {
				$query = $this->db->get('activities',$n);
			} else {
				$query = $this->db->get('activities');
			}

			return $query->result_array();
	    }

	    function get_achievements() {
			$query = $this->db->get('achievements');
			$achievements = array();
			$_achievements = $query->result_array();

			foreach($_achievements as $_achievement) {
				$achievements[$_achievement['id']] = $_achievement;
				$achievements[$_achievement['id']]['completed'] = false;
			}

			$query = $this->db->get_where('achievements_for_user', array('user_id'=>$this->session->userdata('known_user')));
			$_completed_achievements = $query->result_array();

			foreach($_completed_achievements as $_achievement) {
				$achievements[$_achievement['achievement_id']]['completed'] = true;
			}

			return $achievements;
	    }

	    function get_online_offline_activity() {
	    	// coming soon
	    }

	    function get_latest_activities($n) {
	    	// get the last $n activities
			$this->db->select('id,slug');
			$this->db->order_by('id', 'desc');
			$this->db->limit($n);
			$query = $this->db->get('activities');
			
			$result = $query->result_array();
			$activities = array();

			for ($i = 0; $i<$n; $i+=1) {
				if ($i < count($result)) {
					$activities[$i] = self::get_activity($result[$i]['slug']);
				} else {
					return $activities;
				}
			}
			return $activities;
	    }
	    
	    private function _get_activity($slug_or_id) {
	    	if (intval($slug_or_id)>0) {
	    		$query = $this->db->get_where('activities', array('id'=>intval($slug_or_id)), 1);
	    	} else {
	    		$query = $this->db->get_where('activities', array('slug'=>$slug_or_id), 1);
	    	}
	    	if (!$query->num_rows()) {
	    		return false;
	    	}
			$result = $query->result_array();
			$activity = $result[0];
			$activity['player_count'] = explode(',', $activity['player_count']);
			$activity['ingredients'] = explode(',', $activity['ingredients']);

			/* join matching submissions */
			$submissions = self::_get_submissions($activity['id']);
			$activity['submissions'] = $submissions;
			
			return $activity;
	    }

	    private function _get_ingredients($activity_id) {
	    	
			$this->db->select('ingredient_id');
			$query = $this->db->get_where('ingredients_for_activity', array('activity_id' => $activity_id));
			$result = $query->result_array();

			$ingredient_ids = array();
			foreach($result as $value) {
				array_push($ingredient_ids, $value['ingredient_id']);
			}

			$this->db->from('ingredients');
			$this->db->where_in('id', $ingredient_ids);
			$query = $this->db->get();
			return $query->result_array();
	    }

	    private function _get_submissions($activity_id) {
	    	$this->load->model('submission_model');

	    	$this->db->select('id');
	    	$this->db->order_by('id', 'desc');
			$query = $this->db->get_where('submissions', array('activity_id' => $activity_id));
			$submission_ids = $query->result_array();

			$submissions = array();
			foreach($submission_ids as $_id) {
				array_push($submissions, $this->submission_model->get_submission($_id['id']));
			}

			return $submissions;
	    }
	}
?>