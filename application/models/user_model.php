<?php 
	class User_model extends CI_Model {

		// constants defining what user data is available
		const MINIMAL = 0;
		const LIMITED = 1;
		const TYPICAL = 2;
		const FULL = 3;

		function __construct()
		{
			parent::__construct();
		}

		function login() {
			// get post variables
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			return self::_login($email, $password);
		}

		function logout() {
			$this->session->set_userdata(array('logged_in'=>false));
			$this->session->unset_userdata('logged_in_user');
			return true;
		}

		function get_current_user_data() {
 
			$logged_in = $this->session->userdata('logged_in');
			$known_user = $this->session->userdata('known_user');

			if (!$logged_in && !$known_user) {
				// unknown user
				// try and find user by ip, cookies could be wiped but ip might still be in database
				$query = $this->db->get_where('users', array('ip'=>$this->input->ip_address()));

				if ($query->num_rows()) {
					$result = $query->result_array();
					self::_update_known_user($result[0]['id']);
					return self::_get_user_data($result[0]['id'], self::LIMITED);
				}

				// can't identify unknown user
				// create new account
				self::create_limited_user();
				self::_update_known_user($this->db->insert_id());
				return self::_get_user_data($this->db->insert_id(), self::LIMITED);
			}

			if ($logged_in) {
				// user is logged in
				return self::_get_user_data($this->session->userdata('logged_in_user'), self::TYPICAL);
			}

			// user is known, but not logged in or doesn't have a confirmed account
			$user_data = self::_get_user_data($known_user, self::LIMITED);
			if ($user_data !== false) {
				return $user_data;
			}

			// user seemed known, but can't be found in the database, possibly due to prolonged inactivity
			// create new account
			self::create_limited_user();
			self::_update_known_user($this->db->insert_id());
			return self::_get_user_data($this->db->insert_id(), self::LIMITED);
		}

		function get_full_user_data($id) {
			return self::_get_user_data($id, self::FULL);
		}

		function get_limited_user_data($id) {
			return self::_get_user_data($id, self::LIMITED);
		}

		function get_minimal_user_data($id) {
			return self::_get_user_data($id, self::MINIMAL);
		}

		public function get_top_users($n) {
			$this->db->select('id');
			$this->db->order_by('level','desc');
			$this->db->order_by('points','desc');
			$this->db->limit($n);
			$this->db->where('password IS NOT NULL', null, false);
			$query = $this->db->get('users');

			$result = $query->result_array(); 
			$users = array();

			for($i=0; $i<$n && $i<$query->num_rows(); $i+=1) {
				$users[$i] = self::get_limited_user_data($result[$i]['id']);
			}
			return $users;
		}

		function get_ranking($user_id = null) {

			$user_id = isset($user_id) ? $user_id : $this->session->userdata('logged_in_user');

			$this->db->select('id');
			$this->db->order_by('level','desc');
			$this->db->order_by('points','desc');
			$query = $this->db->get('users');

			$result = $query->result_array(); 

			$i = 0;
			while($i<$query->num_rows()) {
				if ($result[$i]['id'] == $user_id) {
					return $i+1;
				}
				$i+=1;
			}

			return 999;
		}

		function user_exists($id) {
			
			$user = self::get_limited_user_data($id);
			
			if ($user['date_created']) {
				return true;
			}
			return false;
		}

		function create_limited_user() {

			$data = array(
				'ip' => $this->input->ip_address(),
				'user_group' => rand(0,0)
			);
			
			$result = $this->db->insert('users', $data);
			if ($result) {
				return $this->db->insert_id();
			}

			return false;
		}

		function upgrade_limited_user() {
			// check whether local account is already registered
			if (self::user_exists($this->session->userdata('known_user'))) {
				self::_update_known_user(self::create_limited_user());
			}

			// update local account
			$salt = uniqid();
			$pepper = substr($this->input->post('email'), 0, 4);
			$data = array(
				'ip' => 			$this->input->ip_address(),
				'name' =>			$this->input->post('name'),
				'email' =>			$this->input->post('email'),
				'salt' =>			$salt,
				'password' =>		MD5($this->input->post('password').$salt.$pepper),
				'age' =>			$this->input->post('age'),
				'date_created' => 	date('Y-m-d H:i:s')
				);
			$this->db->where('id', $this->session->userdata('known_user'));
			$this->db->update('users', $data);
			self::_login($this->input->post('email'), '', MD5($this->input->post('password').$salt.$pepper));

			// send email with link to confirm account
			$token = MD5($this->input->post('password').$salt.$pepper);
			$confirm_url = site_url('user/confirm_user/'.$token);

			$this->load->library('email');
			$this->email->from('peekuep@gmail.com', 'Mailbot');
			$this->email->to($this->input->post('email')); 

			$this->email->subject('Bevestig je account');
			$this->email->message('Nice, je eigen account is aangemaakt. 

Om te bevestigen dat dit account daadwerkelijk van jou is, klik je op de onderstaande link of plak je deze in je webbrowser.

'.$confirm_url.'

Groeten,
Mailbot');  

			$this->email->send();

			return true;
		}

		function update_userdata() {
			if ($this->input->post('name')) { $data['name'] = $this->input->post('name'); }
			if ($this->input->post('age')) { $data['age'] = $this->input->post('age'); }
			if ($this->input->post('interests')) { $data['interests'] = $this->input->post('interests'); }
			if ($this->input->post('password')) { 
				$salt = uniqid();
				$pepper = substr($this->input->post('email'), 0, 4);
				$data['password'] = MD5($this->input->post('password').$salt.$pepper);
				$data['salt'] = $salt;
			}
			$this->db->where(array('id'=>$this->session->userdata('logged_in_user')));
			if ($this->db->update('users', $data)) {
				redirect(site_url('profile'));
				exit;
			}

			return false;
		}

		function confirm_user($key) {
			// check if link is valid
			$this->db->select('confirmed_user, id, email');
			$query = $this->db->get_where('users', array('password'=>$key), 1);

			if ($query->num_rows() == 1) {

				// check if user isn't confirmed already
				$result = $query->result_array();
				if($result[0]['confirmed_user']) {
					show_404();
					exit;
				}

				// confirm account that matches the key
				$this->db->where(array('id'=>$result[0]['id']));
				$salt = uniqid();
				$pepper = substr($this->input->post('email'), 0, 4);
				$data = array('confirmed_user'=>1);
				if ($this->db->update('users', $data)) {
					self::_login($result[0]['email'], '', $key);
					return true;
				}

			} else {
				show_404();
				exit;
			}

			return false;
		}

		function get_queues_for_user($id) {
			
			$query = $this->db->get_where('queues', array('user_id'=>$id));
			$queues = $query->result_array();
			$this->db->delete('queues', array('user_id'=>$id));
			
			return $queues;
		}

		function set_queue_for_user($id, $data) {
			$this->db->insert('queues', $data);
		}

		function complete_activity($user_id, $activity_id) {
			// award points and queue message

			// calculate multiplier
			$query = $this->db->get_where('submissions', array('user_id'=>$user_id, 'activity_id'=>$activity_id));
			$m = 1;
			if ($n = $query->num_rows()) {
				$m = 1/$n;
				if ($m<0.25) {
					$m = 0.25;
				}
			}

			// get achievement for queue description
			$query = $this->db->get_where('achievements', array('activity_id'=>$activity_id));
			if ($query->num_rows()) {
				$result = $query->result_array();
				$achievement = $result[0];

				// award achievement if it's the first time
				if ($n == 1) {
					$this->db->insert('achievements_for_user', array('user_id'=>$user_id, 'achievement_id'=>$achievement['id']));
				}

				// calculate award
				$award = round($achievement['value'] * $m);

				// award points
				self::award_points($user_id, $award);

				// define queue message
				$user = self::get_minimal_user_data($user_id);
				$description = str_replace('[user]', $user['name'], $achievement['description']);
				if ($n != 1) {
					$description .= ' (Achievement was al behaald, @punten x '.(round($m*100)/100).')';
				}
				$queue = array(
					'user_id' =>		$user_id,
					'title' =>			$achievement['title'],
					'description' =>	$description,
					'value' =>			$award,
					'type' =>			'activity'
				);

				// update message queue
				self::set_queue_for_user($user_id, $queue);
			}

			// award extra points if this is the first submission
			$query = $this->db->get_where('submissions', array('activity_id'=>$activity_id));
			if ($query->num_rows() == 1) {

				$query = $this->db->get_where('achievements_for_user', array('user_id'=>$user_id, 'achievement_id'=>7));
				if (!$query->num_rows()) {
					// award achievement if it's the first time
					$this->db->insert('achievements_for_user', array('user_id'=>$user_id, 'achievement_id'=>7));
				}

				$query = $this->db->get_where('achievements', array('slug'=>'first'));
				$result = $query->result_array();
				$achievement = $result[0];

				// calculate award
				$award = round($achievement['value'] * $m);

				// award points
				self::award_points($user_id, $award);

				// define queue message
				$user = self::get_minimal_user_data($user_id);
				$description = str_replace('[user]', $user['name'], $achievement['description']);
				if ($n != 1) {
					$description .= ' (Achievement was al behaald, @punten x '.(round($m*100)/100).')';
				}
				$queue = array(
					'user_id' =>		$user_id,
					'title' =>			$achievement['title'],
					'description' =>	$description,
					'value' =>			$award,
					'type' =>			'activity'
				);

				// update message queue
				self::set_queue_for_user($user_id, $queue);
			}	
			
		}

		function award_points($user_id, $points) {
			$user = self::get_limited_user_data($user_id);
			$level_cap = $user['level']*11-6;
			$points = $user['points'] + $points;
			if ($points >= $level_cap) {
				$points -= $level_cap;
				$this->db->set('level', 'level + 1', false);
			}
			$this->db->set('points', $points);
			$this->db->where(array('id'=>$user_id));
			$query = $this->db->update('users');
		}

		public function get_submissions($user_id) {
			$this->load->model('submission_model');

	    	$this->db->select('id');
	    	$this->db->order_by('id', 'desc');
			$query = $this->db->get_where('submissions', array('user_id' => $user_id));
			$submission_ids = $query->result_array();

			$submissions = array();
			foreach($submission_ids as $_id) {
				array_push($submissions, $this->submission_model->get_submission($_id['id']));
			}

			return $submissions;
		}

		public function update_avatar($url) {
			$this->db->where('id', $this->session->userdata('logged_in_user'));
			$result = $this->db->update('users', array('avatar'=>$url));
			if ($result) {
				return true;
			}

			return false;
	    }

	    public function log($source) {
	    	$user = self::get_minimal_user_data($this->session->userdata('known_user'));
	    	if ($user['log_message']!='x') {
		    	$data = array('source'=>$source, 'message'=>$user['log_message']!=''?$user['log_message']:$user['name']);
				$this->db->insert('start_action_log', $data);
			}
	    }

		private function _update_known_user($id) {
			return $this->session->set_userdata(array('known_user'=>$id));
		}

		private function _get_user_data($id, $type = self::LIMITED) {

			if ($type !== self::MINIMAL && $type !== self::LIMITED && $type !== self::TYPICAL && $type !== self::FULL) {
				return false;
			}

			switch ($type) {
				case self::FULL:
					break;
				case self::TYPICAL:
					$this->db->select('id, user_group, log_message, interests, confirmed_user, name, points, level, avatar, fb_id, tw_id, google_id, date_created');
					break;
				case self::LIMITED: default:
					$this->db->select('id, user_group, log_message, interests, confirmed_user, name, points, level, avatar, date_created');
					break;
				case self::MINIMAL:
					$this->db->select('id, user_group, log_message, interests, name, level, points');
					break;
			}
			
			$query = $this->db->get_where('users', array('id'=>$id));
			if ($query->num_rows()) {
				$result = $query->result_array();
				if (!isset($result[0]['name'])) {
					$result[0]['name'] = 'Gast';
				}
				return $result[0];
			}

			return false;
		}

		private function _login($email, $password, $password_hash = false) {
			// get salt & pepper for user
			$this->db->select('salt');
			$query = $this->db->get_where('users', array('email'=>$email));

			// return false if user does not exist
			if (!$query->num_rows()) {
				return false;
			}

			// check whether password authorizes
			$this->db->select('id');
			if ($password_hash) {
				$query = $this->db->get_where('users', array('email'=>$email, 'password'=>$password_hash), 1);
			} else {
				$result = $query->result_array();
				$salt = $result[0]['salt'];
				$pepper = substr($email, 0, 4);
				$query = $this->db->get_where('users', array('email'=>$email, 'password'=>MD5($password.$salt.$pepper)), 1);
			}
			

			if($query->num_rows() == 1) {
				$result = $query->result_array();
				$id = $result[0]['id'];
				$this->session->set_userdata(array('logged_in'=>true, 'logged_in_user'=>$id, 'known_user'=>$id));
				return $query->result();
			} else {
				return false;
			}
		}
	}
?>