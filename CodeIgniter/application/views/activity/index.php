<head><?php echo $google['map']['js']; ?></head>
<!-- show a hint information to user-->
<?php
      if($success != null)
      {
         echo "&nbsp","&nbsp",$success,"<br>","<br>";
      }
 ?>
 <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!-- user delete, remove, join the activities!-->
 <?php foreach ($result as $activity_item): ?>
   <a href="<?php echo site_url("activity/".$activity_item['id']."/".$user_id);?>"><?php echo $activity_item['name']; ?></a>
   <!--user can remove another activities off his list!-->
   <?php echo "&nbsp","&nbsp"; ?>
   <?php
   if($user_id != $activity_item['create_user_id']){
   ?>
          <a href="<?php echo site_url("activity/remove/".$activity_item['id']."/".$user_id);?>">Cancel</a>
   <?php
   }
   ?>
   <!--user can just delete or edit its own activity from database!-->
   <?php
   if($user_id == $activity_item['create_user_id']){
   ?>
           <a href="<?php echo site_url("activity/delete/".$activity_item['id']."/".$user_id);?>">Delete</a>
           <?php echo "&nbsp","&nbsp"; ?>
           <a href="<?php echo site_url("activity/edit/".$activity_item['id']."/".$user_id);?>">Edit</a>
   <?php
   }
   ?>
   <br /><br />
<?php endforeach; ?>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--link to another page!-->
<p><a href="<?php echo site_url("activity/select/".$user_id);?>">Add a new activity</a>|
<a href="<?php echo site_url("activity/showall/".$user_id);?>">See All activities</a></p>
<br /><br />
<a href="<?php echo site_url("logout");?>">Logout</a>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<br><br><br>
<?php echo $google['map']['html']; ?>
