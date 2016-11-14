<head><?php echo $map['js']; ?></head>

<!-- show a hint information to user-->
<?php
      if($success != null)
      {
         echo "&nbsp","&nbsp",$success,"<br>","<br>";
      }
 ?>
 <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!-- user delete, remove, join the activities!-->
<?php $x=0; ?>
 <?php foreach ($result as $activity_item): ?>

   <a href="<?php echo site_url("activity/".$activity_item['id']."/".$user_id);?>"><?php echo $activity_item['name']; ?></a>
   <!--user can remove another activities off his list!-->
   <?php echo "&nbsp","&nbsp"; ?>
   <?php
   if($user_id != $activity_item['create_user_id'] && $success != "All Activities in database has been shown."){
   ?>
   <a href="<?php echo site_url("activity/remove/".$activity_item['id']."/".$user_id);?>">Remove from your List</a>
   <?php
   }
   ?>

   <!--user can join another activity!-->
   <?php echo "&nbsp","&nbsp"; ?>
   <?php
   if($user_id != $activity_item['create_user_id'] && $success == "All Activities in database has been shown." && $array_1[$x]=="true"){
   ?>
   <a href="<?php echo site_url("activity/join/".$activity_item['id']."/".$user_id);?>">Join</a>
   <?php
   }
   ?>
   <?php $x=$x+1; ?>

   <!--user can just delete or edit its own activity from database!-->
   <?php echo "&nbsp","&nbsp"; ?>
   <?php
   if($user_id == $activity_item['create_user_id']){
   ?>
   <a href="<?php echo site_url("activity/delete/".$activity_item['id']."/".$user_id);?>">Delete from database</a>
   <?php echo "&nbsp","&nbsp"; ?><a href="<?php echo site_url("activity/edit/".$activity_item['id']."/".$user_id);?>">Edit your activity</a>
   <?php
   }
   ?>
   <br /><br />
<?php endforeach; ?>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--link to another page!-->
<?php
if($success != "All Activities in database has been shown."){
?>
<p><a href="<?php echo site_url("activity/select/".$user_id);?>">Add a new activity</a>|
<a href="<?php echo site_url("activity/index/all/".$user_id);?>">See All activities</a></p>
<?php
}
?>

<?php
if($success == "All Activities in database has been shown."){
?>
<p><a href="<?php echo site_url("activity/index/SFU/".$user_id);?>">Back to your activities</a>
<?php
}
?>

<br /><br />
<a href="<?php echo site_url("logout");?>">Logout</a>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<br><br><br>
 <?php echo $map['html']; ?>
