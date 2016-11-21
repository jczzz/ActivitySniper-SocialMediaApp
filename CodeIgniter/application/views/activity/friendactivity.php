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
<ul class="list-group">
<?php foreach ($result as $activity_item): ?>
  <li class="list-group-item"><a href="<?php echo site_url("activity/view_friend_activity/".$activity_item['id']."/".$user_id);?>"><?php echo $activity_item['name']; ?></a>
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
        <a href="<?php echo site_url("activity/join_friend_activity/".$activity_item['id']."/".$user_id);?>">Join</a>
    <?php
      }
     ?>
   </li>
<?php $x=$x+1; ?>
<?php endforeach ?>
</ul>
</div>
</div>
</div>

<div id="mapshow" class="col-md-6 col-md-offset-0">
  <?php echo $google['map']['html']; ?>
</div>
