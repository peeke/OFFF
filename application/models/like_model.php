<?php 

class Like_model extends CI_Model {

	public function get_like($user_id, $submission_id) {
		$query = $this->db->get_where('likes', array('user_id'=>$user_id, 'submission_id'=>$submission_id));
		if ($query->num_rows()>0) {
			return true;
		}
		return false;
	}

	public function set_like($user_id, $submission_id) {
		$query = $this->db->insert('likes', array('user_id'=>$user_id, 'submission_id'=>$submission_id));
		$query = $this->db->get_where('submissions', array('id'=>$submission_id));
		$submissions = $query->result_array();
		$submission = $submissions[0];
		$user_id = $submission['user_id']; // update score for user that submission belongs to
		$query = $this->db->get_where('queues', array('user_id'=>$user_id, 'title'=>'Je bent geliked!'));
		if ($query->num_rows()>0) {
			$queue = $query->result_array();
			$value = $queue[0]['value']+1;
			$this->db->where(array('user_id'=>$user_id, 'type'=>'like'));
			$this->db->set('value','value+1',false);
			$this->db->set('description', self::_get_like_queue_description($value));
			$this->db->update('queues');
		} else {
			$this->db->insert('queues', array(
				'user_id' =>		$user_id,
				'title' =>			'Je bent geliked!',
				'description' =>	self::_get_like_queue_description(1),
				'value' =>			1,
				'type' =>			'like'
				));
		}
		$this->user_model->award_points($user_id, 1);
	}

	private function _get_like_queue_description($value) {
		$descriptions = array(
			'Je bent '.$value.'x geliked. '.$value.' Extra @-punten!',
			'Dat gaat lekker, '.$value.' extra @-punten voor je likes.',
			'Goed bezig, '.$value.' nieuwe likes!',
			'Dat begint erop te lijken, '.$value.' nieuwe likes'
			);
		$description = $descriptions[rand(0,count($descriptions)-1)];
		if ($value == 1) {
			$description = str_replace('likes', 'like', $description);
			$description = str_replace('punten', 'punt', $description);
		}

		return $description;
	}
}

?>