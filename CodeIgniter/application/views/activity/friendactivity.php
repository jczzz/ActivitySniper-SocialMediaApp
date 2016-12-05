<head>
<?php echo $google['map']['js']; ?>
<style>
  #mapshow {  float:right; margin-top:0em;  }
</style>
</head>
<div class="col-sm-6 col-md-offset-0">
  <div class="panel panel-default">
    <div class="panel-body">
<?php $x=0; ?>

<table class="table table-hover">
  <thead>
    <tr>
      <th>Activity Name</th>
      <th>Created By</th>
      <th>Happen in</th>
      <th class="text-right">Control</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($result as $activity_item): ?>
  <tr>
  <td><a href="<?php echo site_url("activity/view_friend_activity/".$activity_item['id']."/".$user_id);?>"><?php echo $activity_item['name']; ?></a></td>
  <?php echo "&nbsp","&nbsp"; ?>
  <!--determine the owner-->
  <td>
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
  </td>



 <?php
     if ($activity_item['date']>date('Y-m-d'))
      {
        $activity_date = DateTime::createFromFormat('Y-m-d', $activity_item['date']);
        $today = new DateTime('now');
        $diff=$activity_date->diff($today)->days;
  ?>                      
         <td>  <?php echo $diff,"&nbsp","Days";?> </td>
 <?php  } ?>

 <?php 
      if ($activity_item['date']==date('Y-m-d'))
      {
        $activity_date = DateTime::createFromFormat('Y-m-d', $activity_item['date']);
        $today = new DateTime('now');
        $diff=$activity_date->diff($today)->days;
  ?>
      <td style=" color: red;">  <?php echo "Today ! Hurry!"; ?> </td>
  <?php  } ?>

   <?php 
      if ($activity_item['date']<date('Y-m-d'))
      {
  ?>
      <td style=" color: grey;">  <?php echo "Past";?> </td>
  <?php  } ?>







  
    <!--can join-->
    <td class="text-right">
    <?php echo "&nbsp","&nbsp"; ?>
    <?php if($view_user_id != $activity_item['create_user_id'] && $array_1[$x]=="true"){
    ?>
        <a class="btn btn-info" href="<?php echo site_url("activity/join_friend_activity/".$activity_item['id']."/".$user_id);?>">Join</a>
    <?php
      }
     ?>
   </td>
   </tr>
<?php $x=$x+1; ?>
<?php endforeach ?>
</table>
</tbody>
</div>
</div>
</div>

<div id="mapshow" class="col-md-6 col-md-offset-0">
  <?php echo $google['map']['html']; ?>
</div>
