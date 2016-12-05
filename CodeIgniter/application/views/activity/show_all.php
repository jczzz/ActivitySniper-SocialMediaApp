<head><?php echo $google['map']['js']; ?></head>


<div class="col-sm-6">
  <div class="panel panel-default">
    <div class="panel-body">
<!-- show a hint information to user-->
<div class="list-group-item-success">
<?php echo "&nbsp","&nbsp",$success,"<br>","<br>"; ?>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--search-->
<?php echo form_open("activity/showall"); ?>
      <fieldset>
        <div class="form-group">
          <label for="Search" class="cols-sm-2 control-label">Type some key words here with check box choiced: (if empty, will give all activities + one or more time choiced) </label>
          <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></span>
            <input type="input" class="form-control" name="search"  placeholder="Enter some key words"/>



             <span class="input-group-btn"><input class="btn btn-success" type="submit" name="submit" value="Search">
            </span>
      </div>

              <input type="checkbox" name="t" value="t" >today 
              <input type="checkbox" name="f" value="f" >future 5 days
              <input type="checkbox" name="b" value="b" >beyond 5 days 

    </div>
      </fieldset>

</form>
<br />

<!--show all activities-->
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
<?php $x=0; ?>
<?php foreach($result as $activity_item): ?>
  <tr>






<?php   //filter wanted date activities according to happening time
      
        if(   $activity_item['date']<date('Y-m-d') and 
            (
                $this->input->post('t') or
                $this->input->post('f') or
                $this->input->post('b')
            )
        )
        {continue;}

        if(   $activity_item['date']==date('Y-m-d') and 
            (
                !$this->input->post('t') and
                (
                 $this->input->post('f') or
                 $this->input->post('b')
                )
            )
        )
        {continue;}


        $activity_date = DateTime::createFromFormat('Y-m-d', $activity_item['date']);
        $today = new DateTime('now');
        $diff=$activity_date->diff($today)->days;

        if(  $diff >0 and $diff <=5 and 
            (
                !$this->input->post('f') and
                (
                 $this->input->post('t') or
                 $this->input->post('b')
                )
            )
        )
        {continue;}

        if(   $diff >5 and 
            (
                !$this->input->post('b') and
                (
                 $this->input->post('t') or
                 $this->input->post('f')
                )
            )
        )
        {continue;}

?>









  <td><a href="<?php echo site_url("activity/".$activity_item['id']);?>"><?php echo $activity_item['name'];?></a></td>
  <?php echo "&nbsp","&nbsp"; ?>
  <?php
  if($user_id != $user_result[$x]['id']){
  ?>
        <td><a href="<?php echo site_url("user/information/".$user_result[$x]['id']);?>"><?php echo $user_result[$x]['email'];?></a></td>
   <?php
   }
   ?>
   <?php
   if($user_id == $user_result[$x]['id']){
   ?>
         <td><?php echo "You";?></td>
   <?php
   }
   ?>


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



  <?php echo "&nbsp","&nbsp"; ?>
  <td class="text-right">
  <?php if($user_id != $activity_item['create_user_id'] && $array_1[$x]=="true"){
  ?>
        <a class="btn btn-info" href="<?php echo site_url("activity/join/".$activity_item['id']);?>">Join</a>
  <?php
    }
   ?>
   <?php if($user_id == $activity_item['create_user_id']){
   ?>
         <a class="btn btn-info" href="<?php echo site_url("activity/edit/".$activity_item['id']);?>">Edit</a>
         <?php echo "&nbsp","&nbsp"; ?>
         <a class="btn btn-danger"  href="<?php echo site_url("activity/delete/".$activity_item['id']);?>">Delete</a>
   <?php
     }
    ?>
    </td>

    <?php $x=$x+1; ?>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
<!--link to another page!-->

<div id="mapshow" class="col-md-6 col-md-offset-0">
  <?php echo $google['map']['html']; ?>
</div>




