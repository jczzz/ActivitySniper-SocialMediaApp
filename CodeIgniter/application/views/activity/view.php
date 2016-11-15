<head><?php echo $map['js']; ?></head>
    <h1><?php echo $result['name']?></h1>
    <?php
      if($success !=null)
      {
        echo "&nbsp","&nbsp",$success,"<br>","<br>";
      }
    ?>
    Activity name:<br/>
    <?php  echo "&nbsp","&nbsp",$result['name'];?><br />
    Activity date:<br/>
    <?php  echo "&nbsp","&nbsp",$result['date'];?><br />
    Activity time:<br/>
    <?php  echo "&nbsp","&nbsp",$result['time'];?><br />
    Catagory:<br/>
    <?php  echo "&nbsp","&nbsp",$result['catagory'];?><br />
    Location Lng:<br/>
    <?php  echo "&nbsp","&nbsp",$result['location_lng'];?><br />
    Location lat:<br/>
    <?php  echo "&nbsp","&nbsp",$result['location_lat'];?><br />
    Description:<br/>
    <?php  echo "&nbsp","&nbsp",$result['description'];?><br />
    <br />
    <a href="<?php echo site_url("activity/index/sfu/".$user_id);?>">List of Activities</a>

    <br>
    <br>
    <br>

    <?php echo $map['html']; ?>

    <br>
    <br>
    <br>
    Comments:<br>

    <?php foreach ($comments as $comment_item): ?>
    <?php
      if($result['id'] === $comment_item['activity_id']){
        echo "User: ",$comment_item['email'],"&nbsp";
        echo "On: ",$comment_item['date'],"&nbsp", $comment_item['time'],"&nbsp", "<br>";
        echo "Said: ",$comment_item['comment'],"<br> <br>";
      }

    ?>

    <?php endforeach; ?>
