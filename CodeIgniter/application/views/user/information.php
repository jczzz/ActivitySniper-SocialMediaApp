<div class="col-sm-6 col-sm-offset-3">
  <div class="panel panel-default">
    <div class="panel-body">
      <ul class="list-group">
        <img src="/static/<?php echo $result['picture'];?>" class="img-thumbnail center-block img-responsive">
        <br>
        <li class="list-group-item"><label for="Email" class="cols-sm-2 control-label">Email:</label><br >
          <?php  echo "&nbsp","&nbsp",$result['email'];?><br />
        </li>

        <li class="list-group-item"><label for="Phone number" class="cols-sm-2 control-label">Phone number:</label><br >
          <?php  echo "&nbsp","&nbsp",$result['phonenum'];?><br />
        </li>

        <li class="list-group-item"><label for="Notes" class="cols-sm-2 control-label">Notes:</label><br >
          <?php  echo "&nbsp","&nbsp",$result['notes'];?><br />
        </li>

        <?php
        if($check == "true" && $user_id != $view_user_id && $view_user_id != 1){
          ?>
          <li class="list-group-item text-center"><a class="btn btn-info" href="<?php echo site_url("user/friend/$user_id/")?>">Add To Friend List</a></li>
          <?php
        }
        ?>

        <?php
        if($check == "false" && $user_id != $view_user_id){
          ?>
          <li class="list-group-item text-center"><a class="btn btn-info" href="<?php echo site_url("activity/friendactivity/$user_id/")?>">See your friend's Activities</a>
            <a class="btn btn-danger" href="<?php echo site_url("user/deletefriend/$user_id/")?>">Delete from friend List</a>
          </li>

          <?php
          }
          ?>
              <li class="list-group-item"><label for="messages" class="cols-sm-2 control-label">Leaved messages:</label><br/><br>

                <?php foreach ($messages as $m_item): ?>

                <?php 
                if($m_item['user_id1']===$user_id)   
                {         
                    echo "&nbsp";
                    echo "(",$m_item['date'],",&nbsp", $m_item['time'],")",",&nbsp &nbsp";
                    echo $m_item['firstname'],"&nbsp",$m_item['lastname'],"&nbsp","has said:","&nbsp",$m_item['comment'];
                    echo "<br>";
                }
                ?>
                

                <?php endforeach; ?>
                </li>


                <?php $aid = $result['id']; ?>
                <?php
                  date_default_timezone_set("America/Vancouver");
                ?>
                <div class="list-group-item-danger">
                  
                  <?php echo form_open("user/information/$user_id"); ?>
                </div>
                  <fieldset>
                      <input type="hidden" name="user_id1" value="<?php echo $user_id; ?>"/>
                      <input type="hidden" name="user_id2" value="<?php echo  $view_user_id; ?>"/>
                      <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>"/>
                      <input type="hidden" name="time" value="<?php echo date('H:i:s'); ?>"/>
                      <div class="form-group">
                          <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></span>
                              <input type="text" class="form-control" id="myComment" name="message" placeholder="Type some messages"/><br />
                              <span class="input-group-btn"><input class="btn btn-info" type="submit" name="submit" value="Post"  >
                              </span>
                        </div>
                    </div>
                </fieldset>
                </form>

                <?php
      $session_data=$this->session->userdata('logged_in');
        $logged_user_id=$session_data['id'];
       ?>
        <div style="margin-top:15px;" class="col-lg-12 col-sm-12 col-xs-12 msg-outer"> 
          <form method="post" action="<?php echo site_url('messages/send_message'); ?>">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="col-lg-4 col-md-4 col-xs-4 lbl-inner">
                   <span>
                     <label>Send New Message</label>
                   </span> 
                </div> 
      
                <div class="col-lg-6 col-md-6 col-xs-6 field-inner">
                   <span class="reg-field">
                     <textarea placeholder="Write your message..." required class="form-control" name="message" rows="3" ></textarea>
                     <input type="hidden" name="sender_id" value="<?php echo  $logged_user_id; ?>">
                     <input type="hidden" name="receiver_id" value="<?php echo $result['id']; ?>">
                     
                   </span> 
                </div>
                <div class="col-lg-2 col-md-2 col-xs-2 field-submit">
                    <button class="btn btn-success" type="submit" class="move">Send</button>
                </div>
           
            </div> 
         </form> 
        
        </div>
      </ul>
    </div>
  </div>
</div>
