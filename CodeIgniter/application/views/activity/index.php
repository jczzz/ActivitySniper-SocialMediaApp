<head>
<?php echo $google['map']['js']; ?>
<style type="text/css">
    #calendar { float:right; width:40%; height: 40%; margin: -120px; margin-top:-300px; margin-right:-250px; }
</style>
</head>
<!-- show a hint information to user-->
<?php
      if($success != null)
      {
         echo "&nbsp","&nbsp",$success,"<br>","<br>";
      }
 ?>
 <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
  <?php $x=0; ?>
<!-- user delete, remove, join the activities!-->
 <?php foreach ($result as $activity_item): ?>
   <a href="<?php echo site_url("activity/".$activity_item['id']."/".$user_id);?>"><?php echo $activity_item['name']; ?></a>
   <?php echo "&nbsp","&nbsp"; ?>
   <?php echo "created by "?>
   <?php
   if($user_id != $user_result[$x]['id']){
   ?>
         <a href="<?php echo site_url("user/information/".$user_result[$x]['id']."/".$user_id);?>"><?php echo $user_result[$x]['email'];?></a>
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
   <!--user can remove another activities off his list!-->
   <?php echo "&nbsp","&nbsp"; ?>
   <?php
   if($user_id != $activity_item['create_user_id']){
   ?>
          <a href="<?php echo site_url("activity/remove/".$activity_item['id']."/".$user_id);?>">Cancel</a>
          <?php echo "&nbsp","&nbsp"; ?>
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
   <?php $x=$x+1;?>
   <br /><br />
<?php endforeach; ?>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--link to another page!-->
<p><a href="<?php echo site_url("activity/create/".$user_id);?>">Add a new activity</a>|
<a href="<?php echo site_url("activity/showall/".$user_id);?>">See All activities</a>|
<a href="<?php echo site_url("user/friendlist/".$user_id);?>">Friend List</a></p>
<br /><br />
<a href="<?php echo site_url("logout");?>">Logout</a>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<br><br><br>

<div id="calendar">
<?php echo $calendar_1;?>
</div>
<?php echo $google['map']['html']; ?>
