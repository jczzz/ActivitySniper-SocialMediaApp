<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {
	
	public function __construct()
    {
		parent::__construct();
		
		$config = Array(
	    'protocol' => 'smtp',
	    'smtp_host' => 'smtp.mailgun.org',
	    'smtp_port' => 587,
	    'smtp_crypto' => 'sslv2',
	    'smtp_user' => 'postmaster@3dcrossingmobeen.mailgun.org',
	    'smtp_pass' => '48qr3xq2thk3',
	    'mailtype'  => 'html', 
	    'charset'   => 'iso-8859-1'
		); 
		$this->load->library('email',$config);
		
		
		$this->load->model('messages_model');
		$this->load->model('activity_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->helper('url');
		$this->load->helper('common_helper');
	}
	
	public function index ()
	{
		/*if($this->session->userdata('logged_in')){
			redirect('user/login','refresh');
		}*/
		$session_data=$this->session->userdata('logged_in');
        $user_id=$session_data['id'];

        $data['user_result']=null;
        $data['success']=null;
        $data['title']="My Messages";
        $data['result']=null;
        $data['result1']=null;
        $data['user_id']=$user_id;
		
		//friendlist.
        $data['friend_result']=$this->user_model->get_user_by_view($user_id);
		
		//$limit =2;
		$messages = $this->messages_model->getMyMessages();
		$totalMessages = $this->messages_model->num_messages();
		
		/*$data = array(
			'messages' => $messages,
			'num_messages' => $totalMessages,
		);*/
		
		 $data['messages']=$messages;
		 $data['num_messages']=$totalMessages;
		//var_dump($messages);exit;
		
		$this->load->view('templates/header',$data);
        $this->load->view("messages/my-messages",$data);
        $this->load->view('templates/footer', $data);
		
	}
	
	public function get_messages ($offset)
	{
		$messages = $this->messages_model->getMyMessages($offset);
		
		$data = array(
			'messages' => $messages,
		);
		
		$this->load->view('member/ajaxCalls/load_more_messages', $data);
	}
	
	public function markAsRead($receiver_id,$conversationId)
	{
		$session_data=$this->session->userdata('logged_in');
        $user_id=$session_data['id'];
		
		if($user_id==$receiver_id){
			$vals['message_read'] = '1';
			$this->messages_model->mark_as_read($vals,$conversationId);
		}
		
		redirect('messages/detail/'.$receiver_id.'/'.$conversationId);
	}
	
	function mark_inappropriate()
    {
		echo $this->messages_model->markInappropriate($this->uri->segment('3'));
	}
	
	public function detail($id)
	{
		/*if(!$this->session->userdata('mem_id')){
			redirect('member/login');
		}*/
		
		$session_data=$this->session->userdata('logged_in');
        $user_id=$session_data['id'];

        $data['user_result']=null;
        $data['success']=null;
        $data['title']="Conversation Detail";
        $data['result']=null;
        $data['result1']=null;
        $data['user_id']=$user_id;
		
		//friendlist.
        $data['friend_result']=$this->user_model->get_user_by_view($user_id);
		
		
		$isThisMyConversation = $this->messages_model->getConversationWith($this->uri->segment(4));
		//var_dump($isThisMyConversation);exit;
		if(($isThisMyConversation) && ($isThisMyConversation->user1==$user_id || $isThisMyConversation->user2==$user_id)){
		
		if($this->input->post()){
			$vals = $this->input->post();
			$sender_id = $vals['sender_id'];
			$reciever_id = $vals['receiver_id'];
			$checkConversationExists = $this->messages_model->checkConversation($sender_id, $reciever_id);
			
			if($checkConversationExists)
			{
				$conId = $checkConversationExists;
				$conv['update_time'] = date("Y-m-d H:i:s");
				$this->messages_model->add_Conversation($conv, $checkConversationExists);
				
			} else {
				
				$conv['user1'] = $sender_id;
				$conv['user2'] = $reciever_id;
				$conv['update_time'] = date("Y-m-d H:i:s");
				$conId = $this->messages_model->add_Conversation($conv);
			}
			
			//var_dump($conId);exit;
			$insert['conversation_id'] = $conId;
			$insert['sender_id'] = $sender_id;
			$insert['receiver_id'] = $reciever_id;
			$insert['message'] = $vals['message'];
			$insert['created'] = date("Y-m-d H:i:s");
			$this->messages_model->save($insert);
			
			$this->session->set_flashdata('message', '<span class="alert alert-success" role="alert">Message sent successfully!</span>');
			
			redirect('messages/detail/'.$reciever_id.'/'.$vals['conversation_id']);
			
			
		}
		
		if($user_id==$this->uri->segment(3)){
			$vals['message_read'] = '1';
			$data['read_time'] = date("Y-m-d H:i:s");
			$this->messages_model->mark_as_read($vals,$this->uri->segment(4));
		}
		
		$conversationDetail = $this->messages_model->getConversationDetail($this->uri->segment(4));
		if($conversationDetail){
			
			$conversationWith = $this->messages_model->getConversationWith($this->uri->segment(4));
			/*$data = array(
				'conversationDetail' => $conversationDetail,
				'conversationWith' => $conversationWith,
			);*/
			$data['conversationDetail']=$conversationDetail;
			$data['conversationWith']=$conversationWith;
			//var_dump($messages);exit;
			
			$this->load->view('templates/header',$data);
			$this->load->view('messages/conversation-detail', $data);
			$this->load->view('templates/footer', $data);
		} else {
			redirect('messages');
		}
		
		}else {
			redirect('messages');
		}
		
		
		//var_dump($messages);exit;
		
	}
	
	public function send_message ()
	{
		if($this->input->post()){
			$vals = $this->input->post();
			$sender_id = $vals['sender_id'];
			$reciever_id = $vals['receiver_id'];
			$checkConversationExists = $this->messages_model->checkConversation($sender_id, $reciever_id);
			
			if($checkConversationExists)
			{
				$conId = $checkConversationExists;
				$conv['delete_by_user1'] = '0';
				$conv['update_time'] = date("Y-m-d H:i:s");
				$this->messages_model->add_Conversation($conv, $checkConversationExists);
				
			} else {
				
				$conv['user1'] = $sender_id;
				$conv['user2'] = $reciever_id;
				$conv['update_time'] = date("Y-m-d H:i:s");
				$conId = $this->messages_model->add_Conversation($conv);
			}
			
			//var_dump($conId);exit;
			$insert['conversation_id'] = $conId;
			$insert['sender_id'] = $sender_id;
			$insert['receiver_id'] = $reciever_id;
			$insert['message'] = $vals['message'];
			$insert['created'] = date("Y-m-d H:i:s");
			$this->messages_model->save($insert);
			
			$this->session->set_flashdata('message', '<span class="alert alert-success" role="alert">Message sent successfully!</span>');
			
			redirect('messages/index', 'refresh');
			
			
		}
	}
	
	public function deleteConversation($con_id)
	{
		//echo $con_id;exit;
		$isThisMyConversation = $this->messages_model->getConversationWith($con_id);
		//var_dump($isThisMyConversation);exit;
		if(($isThisMyConversation) && ($isThisMyConversation->user1==$this->session->userdata('mem_id') || $isThisMyConversation->user2==$this->session->userdata('mem_id'))){
			
			$vals['delete_by_user1'] = $this->session->userdata('mem_id');
			$this->messages_model->add_Conversation($vals, $con_id);
			//$this->messages_model->deleteUsingConversationId($con_id);
			redirect('messages');
			
		} else {
		
			redirect('messages');	
		}
	}
}
?>