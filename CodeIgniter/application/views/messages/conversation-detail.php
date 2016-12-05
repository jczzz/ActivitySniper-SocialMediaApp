<div class="col-sm-9 col-sm-offset-1">
  <div class="panel panel-default">
    <div class="panel-body">
    
    <?php 
	$session_data=$this->session->userdata('logged_in');
        $user_id=$session_data['id'];
		
	if($this->session->flashdata('message')){
	 
	 		echo $this->session->flashdata('message');
         } ?>
    <?php 
	
	if( $user_id==$conversationWith->user1){
		$conWith = $conversationWith->user2;
	} else {
		$conWith = $conversationWith->user1;
	}
	
	$conversationId = $conversationWith->id;
	$rcvName = getMember($conWith)
		
	 ?> 
    <!-- <h1>Conversation With <?php //echo ucfirst($rcvName->firstname). ' '.$rcvName->lastname; ?></h1>-->
    <?php 
		//echo $this->db->last_query();
		//var_dump($checkOtherUserBlockedYou);exit;
	
	//var_dump($messages);exit;
	if(count($conversationDetail)>0){ 
		foreach($conversationDetail as $msg){
	?>
    	
     
    <div class="col-lg-12 col-sm-12 col-xs-12 msg-outer"> 
    	 
        <div class="col-lg-11 col-sm-11 col-xs-11 ">
        <div class="col-lg-9 col-sm-9 col-xs-9 ">
        <?php  
		/*if($msg->sender_id==$this->session->userdata('mem_id')){ 
			$senderDetail =  getMember($msg->sender_id);
		} else { 
			$senderDetail =  getMember($msg->receiver_id);
		}*/
		
		$senderDetail =  getMember($msg->sender_id); ?>
        <!--<a href="<?php //echo base_url().'browseProfiles/showProfile/'.$msg->sender_name; ?>">-->
        <h3 style="color: brown;">
		<?php 
		if($msg->sender_id== $user_id){
			echo "You:";
		} else {
		echo ucfirst($msg->sender_name).' '. $msg->sender_lastname. ':'; } ?></h3><!--</a>-->
        
        <p><?php echo $msg->message; ?></p>
        
        
        </div>
        <div class="col-lg-3 col-sm-3 col-xs-3 pd-r msg-control">
        <h5 style="margin-top: 35px;">
        <?php if($msg->sender_id== $user_id){ echo "Sent"; } else { echo "Received"; } ?><br/><?php 
		$date = date_create($msg->created);
echo date_format($date, 'm/d/Y');
		 
			
			//$date = date_create($msg['created']);
//echo date_format($date, 'Y/m/d');
	
		?><!--DD/MM-->
        
        </h5>
       
        </div>
       
        </div>  
 	</div>
 	<hr style="width: 100%;">
    <?php } } else { ?>
    	<div class="col-lg-12 col-sm-12 col-xs-12 msg-outer"> 
        <h1>No Messages Found.</h1>
        </div>
        
        
    <?php } ?>
    <div class="col-lg-12 col-sm-12 col-xs-12 msg-outer"> 
    	
        <form method="post" action="">
        <div class="col-lg-12 col-sm-12 col-xs-12">
       		<div class="col-lg-3 col-md-3 col-xs-3 lbl-inner">
               <span>
                 <label>Send New Message</label>
               </span> 
  			</div> 
  
            <div class="col-lg-6 col-md-6 col-xs-6 field-inner">
               <span class="reg-field">
				 <textarea placeholder="Write your message..." required class="form-control" name="message" rows="3" ></textarea>
                 <input type="hidden" name="sender_id" value="<?php echo  $user_id; ?>">
        		 <input type="hidden" name="receiver_id" value="<?php echo $conWith; ?>">
                 
         		 <input type="hidden" name="conversation_id" value="<?php echo $conversationId; ?>">
               </span> 
          	</div>
            <div class="col-lg-3 col-md-3 col-xs-3 field-submit">
            	<button class="btn btn-success" type="submit" class="move">Send</button>
            </div>
       
        </div> 
        </form> 
 	</div>
    

 </div>
  </div>
</div>
