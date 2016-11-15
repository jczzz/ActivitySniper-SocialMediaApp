<!-- show a hint information to user-->
<?php echo "&nbsp","&nbsp",$success,"<br>","<br>"; ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--show all activities-->
<?php $x=0; ?>
<?php foreach($result as $activity_item): ?>
  <a href="<?php echo site_url("activity/".$activity_item['id']."/".$user_id);?>"><?php echo $activity_item['name'];?></a>
  <?php echo "&nbsp","&nbsp"; ?>
  <?php if($user_id != $activity_item['create_user_id'] && $array_1[$x]=="true"){
  ?>
      <a href="<?php echo site_url("activity/join/".$activity_item['id']."/".$user_id);?>">Join</a>
  <?php
    }
   ?>
   <?php if($user_id == $activity_item['create_user_id']){
   ?>
       <a href="<?php echo site_url("activity/delete/".$activity_item['id']."/".$user_id);?>">Delete</a>
       <?php echo "&nbsp","&nbsp"; ?>
       <a href="<?php echo site_url("activity/edit/".$activity_item['id']."/".$user_id);?>">Edit</a>
   <?php
     }
    ?>
    <br />
    <br />
    <?php $x=$x+1; ?>
<?php endforeach; ?>
<!--link to another page!-->
<p><a href="<?php echo site_url("activity/index/SFU/".$user_id);?>">Back to your activities</a>
