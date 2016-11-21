<head><?php echo $map['js']; ?>
<style>
</style>
</head>

<div class="col-md-6 col-md-offset-0">
  <div class="panel panel-default">
    <div class="panel-body">
              <?php
                if($success !=null)
                {
                  echo "&nbsp","&nbsp",$success,"<br>","<br>";
                }
              ?>
            <ul class="list-group">
              <li class="list-group-item"><label for="activity name" class="cols-sm-2 control-label">Activity name:</label><br >
              <?php  echo "&nbsp","&nbsp",$result['name'];?><br /></li>
              <li class="list-group-item"><label for="activity date" class="cols-sm-2 control-label">Activity date:</label><br >
              <?php  echo "&nbsp","&nbsp",$result['date'];?><br /></li>
              <li class="list-group-item"><label for="activity time" class="cols-sm-2 control-label">Activity time:</label><br/>
              <?php  echo "&nbsp","&nbsp",$result['time'];?><br /></li>
              <li class="list-group-item"><label for="catagory" class="cols-sm-2 control-label">Catagory:</label><br/>
              <?php  echo "&nbsp","&nbsp",$result['catagory'];?><br /></li>
              <li class="list-group-item"><label for="address" class="cols-sm-2 control-label">Address:</label><br/>
              <?php  echo "&nbsp","&nbsp",$result['address'];?><br /></li>
              <li class="list-group-item"><label for="description" class="cols-sm-2 control-label">Description:</label><br/>
              <?php  echo "&nbsp","&nbsp",$result['description'];?><br /></li>
              <br />

              <li class="list-group-item"><label for="description" class="cols-sm-2 control-label">Picture:</label><br/>
              <img src="/static/<?php echo $result['picture'];?>" ><br /></li>
              <br/>
              <li class="list-group-item"><label for="comments" class="cols-sm-2 control-label">Comments:</label><br/><br>

                <?php foreach ($comments as $comment_item): ?>
                <?php
                  if($result['id'] === $comment_item['activity_id']){
                    echo "User: ";
                ?>
                <a href="<?php echo site_url("user/information/".$comment_item['user_id']);?>"><?php echo $comment_item['email'];?></a>
                <?php
                    echo "&nbsp";
                    echo "On: ",$comment_item['date'],"&nbsp", $comment_item['time'],"&nbsp", "<br>";
                    echo "Said: ",$comment_item['comment'],"<br> <br>";
                  }

                ?>

                <?php endforeach; ?>
                </li>

                <?php $aid = $result['id']; ?>
                <?php
                  date_default_timezone_set("America/Vancouver");
                ?>

                <?php echo validation_errors(); ?>
                <?php echo form_open("activity/view/$aid/$user_id"); ?>
                  <fieldset>
                      <input type="hidden" name="uid" value="<?php echo $user_id; ?>"/>
                      <input type="hidden" name="aid" value="<?php echo $result['id']; ?>"/>
                      <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>"/>
                      <input type="hidden" name="time" value="<?php echo date('H:i:s'); ?>"/>
                      <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></span>
                      <input type="text" id="myComment" name="comment" placeholder="Type some comments"/><br />
                    </div>
                    </div>
                      <input class="btn btn-default" type="submit" name="submit" value="Make a comment"  >
                </fieldset>
                </form>
                </ul>
                <?php
                if($friend == "friend"){
                ?>
                      <a href="<?php echo site_url("activity/friendactivity/$user_id");?>">Go back to your friend Activities</a>
                <?php
                 }
                 ?>
    </div>
  </div>
  </div>

    <div id= "map_show" class="col-md-6 col-md-offset-0">
        <?php echo $map['html']; ?>
    </div>

    <br>
    <br>
    <br>
