<?php
class Messages_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function table_name()
    {
    	return "private_messages";
    }

	function num_messages()
	{
		$session_data=$this->session->userdata('logged_in');
        $user_id=$session_data['id'];
		
		$conversationsSql = 'select c.user1 as user1, c.id as conversation_id, c.user2 as user2, c.delete_by_user1 as delete_by_user1 from tbl_conversation c WHERE c.user1="'.$user_id.'" OR c.user2="'.$user_id.'" AND c.delete_by_user1=0 order by c.update_time desc';
		
		$query = $this->db->query($conversationsSql);
		$conversations = $query->result();
		return count($conversations);
	}

    function getMyMessages($offset=0)
    {
		$session_data=$this->session->userdata('logged_in');
        $user_id=$session_data['id'];
		
		//test queries
		/*SELECT * FROM `tbl_private_messages` WHERE (`sender_id`='40' OR `receiver_id`='40') AND created IN (SELECT MAX(p.created) 
		FROM tbl_private_messages p 
		GROUP BY p.sender_id)
                GROUP BY (IF(`sender_id`='40', `receiver_id`, `sender_id`))
				
				
				SELECT * FROM `tbl_private_messages` WHERE (`sender_id`='40' OR `receiver_id`='40') 
GROUP BY (IF(`sender_id`='40', `receiver_id`, `sender_id`)) ORDER BY created DESC


				*/
		
		//for sent messages
		
		/*AND (SELECT pm.message_id,pm.sender_id,pm.receiver_id,pm.message,pm.message_read, pm.created,u.mem_id,u.mem_fname,u.mem_lname, u.mem_username 
		FROM tbl_private_messages pm 
			JOIN tbl_members u 
			ON pm.receiver_id=u.id WHERE pm.sender_id = "'.$this->session->userdata('mem_id').'"
			AND pm.created IN
			(SELECT MAX(p.created)
			FROM private_messages p
			GROUP BY p.receiver_id)
			ORDER BY pm.created DESC)*/
		
		//for received messages
		/*$conversationsSql = 'select pm.message_id, pm.message, c.user1 as user1, c.id as conversation_id, c.user2 as user2 from tbl_conversation c JOIN tbl_private_messages pm ON c.id=pm.conversation_id WHERE c.user1="'.$this->session->userdata('mem_id').'" OR c.user2="'.$this->session->userdata('mem_id').'" group by pm.conversation_id order by pm.created desc';*/
		
		
		$conversationsSql = 'select c.user1 as user1, c.id as conversation_id, c.user2 as user2, c.delete_by_user1 as delete_by_user1 from tbl_conversation c WHERE c.user1="'.$user_id.'" OR c.user2="'.$user_id.'" order by c.update_time desc LIMIT 2 OFFSET '.$offset;
		
		
		
		$query = $this->db->query($conversationsSql);
		$conversations = $query->result();
		//echo $this->db->last_query();
		//echo "<pre>";print_r($conversations);exit;
		$arrConversations = array();
		if(!empty($conversations)){
						
							
						 $i=0;
						foreach($conversations as $con){
							if($con->user1==$user_id){
								$joinId = $con->user2;
							} else {
								$joinId = $con->user1;
							}
							
							$sqlLatestMsg = 'select pm.*, u.id as mem_id, u.firstname as mem_fname, u.lastname as mem_lname, u.picture from private_messages pm JOIN users u 
		ON "'.$joinId.'"=u.id  
		where pm.conversation_id="'.$con->conversation_id.'"
		order by pm.created desc'; // limit 1
							$latestMsgQuery = $this->db->query($sqlLatestMsg);
							$getConversatonMessage = $latestMsgQuery->row();
							//echo $getConversatonMessage->message;
							//var_dump($getConversatonMessage);exit;
							
							$arrConversations[$i] = array(
										"message_id" => $getConversatonMessage->message_id,
										"mem_id" => $getConversatonMessage->mem_id,
										"conversation_id" => $getConversatonMessage->conversation_id,
										'sender_id' => $getConversatonMessage->sender_id,
										'member_fname' =>$getConversatonMessage->mem_fname,
										'member_lname' =>$getConversatonMessage->mem_lname,
										'receiver_id' => $getConversatonMessage->receiver_id,
										'message' => $getConversatonMessage->message,
										'message_read' => $getConversatonMessage->message_read,
										'mark_as_inappropriate' => $getConversatonMessage->mark_as_inappropriate,
										'created' => $getConversatonMessage->created,
										'delete_by_user1' => $con->delete_by_user1,
										/*'message_time' => $getConversatonMessage['created'],
										'first_name' => $getConversatonMessage['first_name'],
										'surname' => $getConversatonMessage['surname'],
										'other_user_id' => $getConversatonMessage['other_user_id'],
										'other_user_type' => $otherUserType,
										'other_user_image' => $getConversatonMessage['picture']*/
							);
							$i++;
						}
						
		}
		//echo "<pre>";print_r($arrConversations);exit;
		return $arrConversations;
		
	//	var_dump($arrConversations);exit;
						
						//var_dump($conversations);exit;
		/*
		$sql = 'SELECT pm.message_id,pm.sender_id,pm.receiver_id,pm.message,pm.message_read, pm.created,u.mem_id,u.mem_fname,u.mem_lname, u.mem_username 
		FROM tbl_private_messages pm 
		JOIN tbl_members u 
		ON pm.sender_id=u.mem_id 
		WHERE (pm.receiver_id = "'.$this->session->userdata('mem_id').'" OR pm.sender_id = "'.$this->session->userdata('mem_id').'")
		AND pm.created IN (SELECT MAX(p.created) 
		FROM tbl_private_messages p 
		GROUP BY p.sender_id) 
		ORDER BY pm.created DESC';
 		//$this->db->where('message_id',$message_id);
		$query = $this->db->query($sql);
		
		//change read status
		//$update = 'UPDATE tbl_private_messages set message_read="1" WHERE receiver_id = '.$user_id;
		
		return $query->result();*/
    }
	
	function getMessageDetails()
    {
		$sql = 'Select p.message_id,p.sender_id,p.receiver_id,p.message,p.message_read, p.created,u.mem_id,u.mem_fname,u.mem_lname, u.mem_username from private_messages p LEFT JOIN tbl_members u ON p.sender_id=u.mem_id LEFT JOIN tbl_members us ON p.receiver_id=us.mem_id WHERE (sender_id = '.$this->session->userdata('mem_id').' AND receiver_id = '.$rcvr.') OR (sender_id = '.$rcvr.' AND receiver_id = '.$this->session->userdata('mem_id').')';
 		//$this->db->where('message_id',$message_id);
		$query = $this->db->query($sql);
		//$query = $this->db->get($this->table_name());		        
		return $query->result();
    }
	
	public function checkConversation($sender_id, $reciever_id)
	{
		//$this->db->select('id');
		$this->db->where('(user1="'.$sender_id.'" AND user2="'.$reciever_id.'") OR (user1="'.$reciever_id.'" AND user2="'.$sender_id.'")');
		//$this->db->or_where('user1="'.$reciever_id.'" AND user2="'.$sender_id.'".'); 
		$query = $this->db->get('tbl_conversation');		        
		$rs = $query->row();
		if($rs){
			return $rs->id;
		} else {
			return false;	
		}
		
	}
	
	function getReportedMessages()
    {
		$this->db->select('pm.*, sndr.mem_id as sender_id,  sndr.mem_username as sender_name, rcvr.mem_username as receiver_name');
		$this->db->from('tbl_private_messages pm');
		$this->db->join('tbl_members sndr', 'sndr.mem_id = pm.sender_id');
		$this->db->join('tbl_members rcvr', 'rcvr.mem_id = pm.receiver_id');
		$this->db->where('pm.mark_as_inappropriate','1');
		//$this->db->order_by('pm.created','asc');
		$this->db->order_by('pm.mark_as_inappropriate','asc');
		
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
		//echo "<pre>";print_r($rs);exit;

    }
	
	function getConversationDetail($con_id)
    {
		$this->db->select('pm.*, sndr.id as sender_id,  sndr.firstname as sender_name, sndr.lastname as sender_lastname,  rcvr.firstname as receiver_name, rcvr.lastname as receiver_lastname');
		$this->db->from('private_messages pm');
		$this->db->join('users sndr', 'sndr.id = pm.sender_id');
		$this->db->join('users rcvr', 'rcvr.id = pm.receiver_id');
		$this->db->where('pm.conversation_id',$con_id);
		$this->db->order_by('pm.created','asc');
		
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
		//echo "<pre>";print_r($rs);exit;

    }
	
	public function getConversationWith($con_id)
	{
		$this->db->where('id',$con_id);
		$this->db->from('tbl_conversation');
		$query = $this->db->get();
		$rs = $query->row();
		return $rs;
		//echo "<pre>";print_r($rs);exit;

    }
	
	public function add_Conversation($vals,$con_id='')
	{
		
		$this->db->set($vals);
		if($con_id != ''){
			$this->db->where('id',$con_id);
			$this->db->update('tbl_conversation');
		}else{
			$this->db->insert('tbl_conversation');
			return $this->db->insert_id();
		}
		
	}
	
	
	function delete($message_id)
    {
    	$this->db->where('message_id',$message_id);
    	$this->db->delete($this->table_name());		        
	}
	
	function deleteUsingConversationId($con_id)
    {
    	$this->db->where('conversation_id',$con_id);
    	$this->db->delete($this->table_name());		        
	}
	
	function changeStatus($message_id)
    {
		$this->db->where('message_id',$message_id);
		$query = $this->db->get($this->table_name());		        
		$rs = $query->row();
			
		if($rs->message_read == '0'){
			$vals['message_read'] = '1';
		}else{
			$vals['message_read'] = '0';
		}
		$this->db->set($vals);
    	$this->db->where('message_id',$message_id);
		$this->db->update($this->table_name());
		return $vals['message_read'];        
	}
	
	function markInappropriate($message_id)
    {
		$this->db->where('message_id',$message_id);
		$query = $this->db->get($this->table_name());		        
		$rs = $query->row();
			
		if($rs->mark_as_inappropriate == '0'){
			$vals['mark_as_inappropriate'] = '1';
		}else{
			$vals['mark_as_inappropriate'] = '0';
		}
		$this->db->set($vals);
    	$this->db->where('message_id',$message_id);
		$this->db->update($this->table_name());
		return $vals['mark_as_inappropriate'];        
	}
	
	function mark_as_read ($vals, $conversation_id)
	{
		$this->db->set($vals);
		$this->db->where('conversation_id',$conversation_id);
		$this->db->update($this->table_name());
	}
	
	function save($vals,$message_id = '')
    {
		$this->db->set($vals);
		if($message_id != ''){
			$this->db->where('message_id',$message_id);
			$this->db->update($this->table_name());
			return $message_id;
		}else{
			$this->db->insert($this->table_name());
			return $this->db->insert_id();
		}
	}
	
	
}
?>