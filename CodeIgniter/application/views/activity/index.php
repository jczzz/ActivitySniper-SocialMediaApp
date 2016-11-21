
<head>
<?php echo $google['map']['js']; ?>
<style type="text/css">
    #calendar { float:right; width:40%; height: 40%; margin: -120px; margin-top:0px; margin-right:-250px; }
    #mapshow {  float:right; margin-top:0em;  }
</style>
</head>
  <div class="col-sm-6">
    <div class="panel panel-default">
      <div class="panel-body">
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
<ul class="list-group">
<?php $count=count($result);?>
 <?php foreach ($result as $activity_item): ?>
   <li class="list-group-item"><a  href="<?php echo site_url("activity/".$activity_item['id']);?>"><?php echo $activity_item['name']; ?></a>
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
   <!--user can remove another activities off his list!-->
   <?php echo "&nbsp","&nbsp"; ?>
   <?php
   if($user_id != $activity_item['create_user_id']){
   ?>
          <a class="btn btn-default" href="<?php echo site_url("activity/remove/".$activity_item['id']);?>">Cancel</a>
          <?php echo "&nbsp","&nbsp"; ?>
   <?php
   }
   ?>
   <!--user can just delete or edit its own activity from database!-->
   <?php
   if($user_id == $activity_item['create_user_id']){
   ?>
           <a class="btn btn-default" href="<?php echo site_url("activity/delete/".$activity_item['id']);?>">Delete</a>
           <?php echo "&nbsp","&nbsp"; ?>
           <a class="btn btn-default" href="<?php echo site_url("activity/edit/".$activity_item['id']);?>">Edit</a>
   <?php
   }
   ?>
   <?php $x=$x+1;?>
      
   </li>

<?php endforeach; ?>
</ul>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--link to another page!-->
<p><a class="btn btn-default" href="<?php echo site_url("activity/create/");?>">Add a new activity</a>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
</div>
</div>
</div>
<!--calendar
<div id="calendar">
<?php //echo $calendar_1;?>
</div>
-->

<div id="mapshow" class="col-md-6 col-md-offset-0">
  <?php echo $google['map']['html']; ?>
</div>
