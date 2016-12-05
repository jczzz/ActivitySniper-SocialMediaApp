<head>
<link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.css' />

      <script src='//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
  <script src='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.js'></script>



<style>
#calendar {
  /*max-width: 900px;*/
  margin: 0 auto;
  float: left;
    width: 100%;
 }

 </style>

<?php echo $google['map']['js']; ?>

<script>

 $(document).ready(function() {

  $('#calendar').fullCalendar({
    header: {
    left: 'prev,next today',
    center: 'title',
    right: ''
        },
   defaultDate: '<?php echo date("Y-m-d");//$today_date; ?>',
   editable: true,
   eventLimit: true, // allow "more" link when too many events
   events: [
     <?php foreach ($result as $activity_item): ?>
     {
       title: '<?php echo $activity_item['name']; ?>',
       start: '<?php echo $activity_item['date']; ?>',
       url: '<?php echo site_url("activity/".$activity_item['id']);?>' ,
      //slots: 'Event Slots: <?php //echo $event["event_slots"]; ?>' ,
      // organizer: 'Event Organizer: <?php //echo $event["event_organizer"]; ?>' ,
      // eventTime: '10:00'
     },
        <?php endforeach; ?>

   ]
  });

 });

</script>
<style type="text/css">
    #calendar { float:right; width:40%; height: 40%; margin: -120px; margin-top:0px; margin-right:-250px; }
    #mapshow {  float:right; margin-top:0em;  }

</style>
</head>
  <div class="col-sm-6">
    <div class="panel panel-default">
      <div class="panel-body">
<!-- show a hint information to user-->
<div class="list-group-item-success">
<?php
      if($success != null)
      {
         echo "&nbsp","&nbsp",$success,"<br>","<br>";
      }
 ?>
 </div>
 <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
  <?php $x=0; ?>
<!-- user delete, remove, join the activities!-->
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
<?php $count=count($result);?>
 <?php foreach ($result as $activity_item): ?>

  <tr>
   <td><a  href="<?php echo site_url("activity/".$activity_item['id']);?>"><?php echo $activity_item['name']; ?></a></td>


   <?php echo "&nbsp","&nbsp"; ?>

   <?php
   if($user_id != $user_result[$x]['id']){
   ?>
        <td> <a href="<?php echo site_url("user/information/".$user_result[$x]['id']);?>"><?php echo $user_result[$x]['email'];?></a></td>
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








   <!--user can remove another activities off his list!-->

   <?php echo "&nbsp","&nbsp"; ?>
   <?php
   if($user_id != $activity_item['create_user_id']){
   ?>
          <td class="text-right"><a class="btn btn-danger" href="<?php echo site_url("activity/remove/".$activity_item['id']);?>">Cancel</a></td>
          <?php echo "&nbsp","&nbsp"; ?>
   <?php
   }
   ?>
   <!--user can just delete or edit its own activity from database!-->
   <?php
   if($user_id == $activity_item['create_user_id']){
   ?>
           <td  class="text-right" ><a class="btn btn-info" href="<?php echo site_url("activity/edit/".$activity_item['id']);?>">Edit</a>
           <?php echo "&nbsp","&nbsp"; ?>
           <a class="btn btn-danger"  href="<?php echo site_url("activity/delete/".$activity_item['id']);?>">Delete</a></td>
   <?php
   }
   ?>
   <?php $x=$x+1;?>

 </tr>

<?php endforeach; ?>
</tbody>
</table>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--link to another page!-->
<p><a class="btn btn-success" href="<?php echo site_url("activity/create/");?>">Add a new activity</a>

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
<div style="margin-top:0px; margin-left:0px;background-color:white;" class="col-md-12 col-md-offset-0">
<div style="float:left;margin:0px;width:100%;" id='calendar'></div>
</div>
