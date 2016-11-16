<?php $x=0; ?>
<?php foreach ($result as $activity_item): ?>
  <?php $friend="friend"; ?>
  <a href="<?php echo site_url("activity/view/".$activity_item['id']."/".$user_id."/".$friend."/".$view_user_id);?>"><?php echo $activity_item['name']; ?></a>
  <?php echo "&nbsp","&nbsp"; ?>
  <!--determine the owner-->
  <?php echo "created by  "; ?>
   <?php
   if(($activity_item['create_user_id'] != $user_id) && ($activity_item['create_user_id'] != $view_user_id)){
   ?>
         <?php echo $user_result[$x]['email'];?>
    <?php
    }
    ?>
    <?php
    if($activity_item['create_user_id'] == $user_id){
    ?>
          <?php echo "Your friend";?>
    <?php
    }
    ?>
    <?php
    if($activity_item['create_user_id'] == $view_user_id){
    ?>
          <?php echo "You";?>
    <?php
    }
    ?>
    <!--can join-->
    <?php echo "&nbsp","&nbsp"; ?>
    <?php if($view_user_id != $activity_item['create_user_id'] && $array_1[$x]=="true"){
    ?>
        <a href="<?php echo site_url("activity/join_friend_activity/".$activity_item['id']."/".$view_user_id."/".$user_id);?>">Join</a>
    <?php
      }
     ?>
<?php $x=$x+1; ?>
<br /><br />
<?php endforeach ?>
<a href="<?php echo site_url("activity/index/SFU/$view_user_id");?>">Go back to your activities</a>
