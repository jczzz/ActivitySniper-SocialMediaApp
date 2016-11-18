<head><?php echo $google['map']['js']; ?></head>
<!-- show a hint information to user-->
<?php echo "&nbsp","&nbsp",$success,"<br>","<br>"; ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--search-->
<?php echo form_open("activity/showall/$user_id"); ?>
      Type some key words here:<br />
      <input type="input" name="search" />
      <input type="submit" name="submit" value="search" >
</form>

<!--show all activities-->
<?php $x=0; ?>
<?php foreach($result as $activity_item): ?>
  <a href="<?php echo site_url("activity/".$activity_item['id']);?>"><?php echo $activity_item['name'];?></a>
  <?php echo "&nbsp","&nbsp"; ?>
  <?php echo "created by "?>
  <?php
  if($user_id != $user_result[$x]['id']){
  ?>
        <a href="<?php echo site_url("user/information/".$user_result[$x]['id']);?>"><?php echo $user_result[$x]['email'];?></a>
   <?php
   }
   ?>
   <?php
   if($user_id == $user_result[$x]['id']){
   ?>
         <?php echo "You";?>
   <?php
   }
   ?>
  <?php echo "&nbsp","&nbsp"; ?>
  <?php if($user_id != $activity_item['create_user_id'] && $array_1[$x]=="true"){
  ?>
      <a href="<?php echo site_url("activity/join/".$activity_item['id']);?>">Join</a>
  <?php
    }
   ?>
   <?php if($user_id == $activity_item['create_user_id']){
   ?>
       <a href="<?php echo site_url("activity/delete/".$activity_item['id']);?>">Delete</a>
       <?php echo "&nbsp","&nbsp"; ?>
       <a href="<?php echo site_url("activity/edit/".$activity_item['id']);?>">Edit</a>
   <?php
     }
    ?>
    <br />
    <br />
    <?php $x=$x+1; ?>
<?php endforeach; ?>
<!--link to another page!-->
<p><a href="<?php echo site_url("activity/index/SFU/");?>">Back to your activities</a>

  <br><br><br>
  <?php echo $google['map']['html']; ?>
