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
    Address:<br/>
    <?php  echo "&nbsp","&nbsp",$result['address'];?><br />
    Description:<br/>
    <?php  echo "&nbsp","&nbsp",$result['description'];?><br />
    <br />
    <img src="/static/<?php echo $result['picture'];?>" ><br />
    <?php
    if($friend != "friend"){
    ?>
          <a href="<?php echo site_url("activity/index/sfu/".$user_id);?>">List of Activities</a>
    <?php
     }
     ?>

     <?php
     if($friend == "friend"){
     ?>
           <a href="<?php echo site_url("activity/friendactivity/$user_id/$view_user_id");?>">Go back to your friend Activities</a>
     <?php
      }
      ?>

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
        echo "User: ";
    ?>
    <a href="<?php echo site_url("user/information/".$comment_item['user_id']."/".$user_id);?>"><?php echo $comment_item['email'];?></a>
    <?php
        echo "&nbsp";
        echo "On: ",$comment_item['date'],"&nbsp", $comment_item['time'],"&nbsp", "<br>";
        echo "Said: ",$comment_item['comment'],"<br> <br>";
      }

    ?>
    <?php endforeach; ?>

    <?php $aid = $result['id']; ?>
    <?php
      date_default_timezone_set("America/Vancouver");
    ?>

    <?php echo form_open("activity/view/$aid/$user_id"); ?>
          <input type="hidden" name="uid" value="<?php echo $user_id; ?>"/>
          <input type="hidden" name="aid" value="<?php echo $result['id']; ?>"/>
          <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>"/>
          <input type="hidden" name="time" value="<?php echo date('H:i:s'); ?>"/>
          <input type="text" id="myComment" name="comment"/><br />
          <?php echo validation_errors(); ?>
          <input type="submit" name="submit" value="Make a comment" >
    </form>
