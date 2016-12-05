<div class="col-sm-9 col-sm-offset-1">
  <div class="panel panel-default">
    <div class="panel-body">
      <ul class="list-group">
       <?php if(count($messages)>0){ 
		foreach($messages as $msg){
			//echo $msg['message_id'];
		?>
        <li class="list-group-item">
          <h3><a href="<?php echo site_url("user/information/".$msg['mem_id']."/")?>"><?php echo ucfirst($msg['member_fname']).' '.ucfirst($msg['member_lname']); ?>:</a></h3>
          <span style="font-size:16px;"><?php echo $msg['message']; ?></span>
          <span><a style="float: right;" href="<?php echo base_url().'messages/detail/'.$msg['receiver_id'].'/'.$msg['conversation_id']; ?>"><strong>View All Conversation with this person</strong></a>
        </span>
        <br />
        </li>

       <?php } } else { echo "No Messages Found."; } ?>

       
      </ul>
    </div>
  </div>
</div>
