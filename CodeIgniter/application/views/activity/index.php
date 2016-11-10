<?php
      if($success != null)
      {
         echo "&nbsp","&nbsp",$success,"<br>","<br>";
      }
 ?>
 <?php foreach ($result as $activity_item): ?>
   <?php echo "&nbsp","&nbsp",$activity_item['name'],"<br>";  ?>

 <?php endforeach; ?>
 <p><a href="http://localhost:9000/index.php/activity/create">Add new activity</a></p>
