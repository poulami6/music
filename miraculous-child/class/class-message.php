<?php 
class Message{

	public $db;
	public $messaging;
	public $messages_user_thread;
	

	function __construct(){
		global $wpdb;
		$this->db = $wpdb;
		$this->messaging = $this->db->prefix.'messages';
		$this->messages_user_thread = $this->db->prefix.'messages_user_thread';
		
	}

	function _format_date($date,$format='j M Y  G:i'){
		$date = strtotime($date);
		$format = date($format , $date );
		return $format;
	}

	function _get_threads_id($sender_id,$receiver_id){

		$q = "SELECT tid FROM $this->messages_user_thread WHERE (receiver_id = $receiver_id OR sender_id =  $receiver_id ) AND ( sender_id = $sender_id OR receiver_id =  $sender_id )  ORDER BY tid desc";
		$res = $this->db->get_row($q);

		if(!empty($res)){
			$tid = $res->tid;
		}else{
			$saveTID = array('sender_id' => $sender_id,'receiver_id' => $receiver_id);
			$msg = $this->db->insert($this->messages_user_thread, $saveTID);
			$tid = $this->db->insert_id;
		}
		
		return $tid;
	}

	function _save_message($savedata){

		$msg  = $this->db->insert($this->messaging, $savedata);
		return $this->db->insert_id;
	}

	function _update_message($savedata,$condition){

		
		$msg  = $this->db->update($this->messaging, $savedata,$condition);
		return $msg;
	}


	function _get_threads_of_user($user_id=false){
		$data = array();
		$user_id = $user_id > 0 ? $user_id : get_current_user_id();

		$q = "SELECT *  FROM $this->messaging WHERE (sender_id = $user_id OR receiver_id =  $user_id) AND deleted_by != $user_id GROUP BY thread_id ORDER BY create_at DESC ";
		
		$result = $this->db->get_results($q);
		if(count($result)){
				$data = $result;
		}
		return $data;
	}


	function _get_message($sender_id,$receiver_id, $reply_id=false, $orderby=''){



		$reply_id = $reply_id > 0 ? $reply_id : 0;

		if($orderby!=''){
			$orderby = 'ORDER BY '.$orderby;
		}else{
			$orderby = 'ORDER BY m_id DESC';
		} 

		$user_id =  get_current_user_id();

		$data = array();
		 $q = "SELECT * FROM $this->messaging WHERE (receiver_id = $receiver_id OR sender_id =  $receiver_id ) AND ( sender_id = $sender_id OR receiver_id =  $sender_id ) AND reply_id = $reply_id AND deleted_by != $user_id $orderby";
		
		$res = $this->db->get_results($q);
		if(count($res)){
			$data = $res;
		}
		return $data;
	}

	function _get_message_by_id($mid){

		$data = array();
		$q = "SELECT * FROM $this->messaging WHERE m_id = $mid";
		
		$res = $this->db->get_row($q);
		if(count($res)){
			$data = $res;
		}
		
		return $data;
	}

	function _get_count_unread_message($userid){

		$data = array();
		$q = "SELECT m_id FROM $this->messaging WHERE receiver_id = $userid AND is_read != $userid ORDER BY m_id desc";
		$res = $this->db->get_results($q);
		if(count($res)){
			$data = $res;
		}
		return $data;
	}

	function _delete_user_message($conditions){

		$res = $this->db->delete($this->messaging,$conditions);
		if(count($res)){
			$data = $res;
		}
		return $data;
	}


	function _get_count_total_unread_message($userid){

		$data = array();
		$q = "SELECT m_id FROM $this->messaging WHERE receiver_id = $userid AND is_read != $userid ORDER BY m_id desc";
		$res = $this->db->get_results($q);
		if(count($res)){
			$data = $res;
		}
		return $data;
	}

	
}