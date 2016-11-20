<head><?php echo $google['map']['js']; ?></head>


<div class="col-sm-6">
  <div class="panel panel-default">
    <div class="panel-body">
<!-- show a hint information to user-->
<?php echo "&nbsp","&nbsp",$success,"<br>","<br>"; ?>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--search-->
<?php echo form_open("activity/showall"); ?>
      <fieldset>
        <div class="form-group">
        <label for="Search" class="cols-sm-2 control-label">Type some key words here: </label>
        <div class="cols-sm-4">
            <input type="input" class="form-control" name="search"  placeholder="Enter some key words"/>
        </div>
        <input class="btn btn-default" type="submit" name="submit" value="search" >
      </div>
      </fieldset>

</form>
<br />
<br />
<br />
<br />
<!--show all activities-->
<?php $x=0; ?>
<label for="Search" class="cols-sm-2 control-label">Activity List:  </label>
<?php foreach($result as $activity_item): ?>
  <li class="list-group-item"><a class="btn btn-default" href="<?php echo site_url("activity/".$activity_item['id']);?>"><?php echo $activity_item['name'];?></a>
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
      <a class="btn btn-default" href="<?php echo site_url("activity/join/".$activity_item['id']);?>">Join</a>
  <?php
    }
   ?>
   <?php if($user_id == $activity_item['create_user_id']){
   ?>
       <a class="btn btn-default" href="<?php echo site_url("activity/delete/".$activity_item['id']);?>">Delete</a>
       <?php echo "&nbsp","&nbsp"; ?>
       <a class="btn btn-default" href="<?php echo site_url("activity/edit/".$activity_item['id']);?>">Edit</a>
   <?php
     }
    ?>
    <br />
    <br />
    <?php $x=$x+1; ?>
  </li>
<?php endforeach; ?>
</div>
</div>
</div>
<!--link to another page!-->

<div id="mapshow" class="col-md-6 col-md-offset-0">
  <?php echo $google['map']['html']; ?>
</div>
