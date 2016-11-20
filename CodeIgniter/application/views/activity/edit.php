<?php echo validation_errors(); ?>
<?php echo $error;?>
<?php
  date_default_timezone_set("America/Vancouver");
?>

<?php echo form_open_multipart("activity/edit/$a_id"); ?>
      <lable "activity name">Activity name: <lable><br />
      <input type="input" name="name" value="<?php echo $result['name']  ?>"/><br />
      <lable "activity date">Activity date: <lable><br />
      <input type="date" name="date"  value="<?php echo $result['date']  ?>"/><br />
      <lable "activity time">Activity time: <lable><br />
      <input type="time" name="time" value="<?php echo $result['time']  ?>"/><br />
      <lable "catagory">Catagory: <lable><br />
      <input type="input" name="catagory" value="<?php echo $result['catagory']  ?>"/><br />
      <lable "address">address: <lable><br />
      <input type="input" name="address" value="<?php echo $result['address']  ?>" /><br />
      <lable "file">Choose a picture: </lable><br />
      <input type="file" name="userfile" size="20" /><br>
      <lable "description">Description: <lable><br />
      <textarea cols="40" rows="10" name="description" ><?php echo $result['description']?></textarea><br />

      <input type="submit" name="submit" value="Edit activity" >
</form>

<br><br><br>



<!DOCTYPE html>
<html>
<head>
  <!--  <link rel="stylesheet" type="text/css" href="/static/g_map_css.css">-->
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAnmxUGSXw3yYnu9tW-FLkaO1qGBb0pDfI&sensor=SET_TO_TRUE_OR_FALSE"></script>
    <script type="text/javascript" src="/static/g_map_js.js"></script>
    <?php echo $map['js']; ?>


</head>
<body onload="initialize()">
  <div class="row vertical-offset-100">
    <div class="col-sm-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">New Activity</h3>
        </div>
        <div class="panel-body">
          <?php echo validation_errors(); ?>
          <?php echo $error;?>
          <?php
            date_default_timezone_set("America/Vancouver");
          ?>

          <?php echo form_open_multipart("activity/edit/$a_id"); ?>
          <form accept-charset="UTF-8" role="form">
            <fieldset>
              <div class="form-group">
                <label for="activity name" class="cols-sm-2 control-label">Activity name</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                    <input type="input" class="form-control" name="name"  placeholder="Enter activity name" value="<?php echo $result['name']  ?>"/>
                  </div>

              </div>

              <div class="form-group">
                <label for="activity date" class="cols-sm-2 control-label">Activity date</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                    <input type="date" class="form-control" name="date"  value="<?php echo $result['date']  ?>"/>
                  </div>

              </div>

              <div class="form-group">
                <label for="activity time" class="cols-sm-2 control-label">Activity time</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                    <input type="time" class="form-control" name="time"  value="<?php echo $result['time']  ?>"/>
                  </div>

              </div>

              <div class="form-group">
                <label for="catagory" class="cols-sm-2 control-label">Catagory</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                    <input type="input" class="form-control" name="catagory"  placeholder="Enter the catagory"/>
                  </div>

              </div>

              <div class="form-group">
                <label for="address" class="cols-sm-2 control-label">Address</label>

                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="address" id="myPlaceTextBox" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button" onclick="codeAddress()">Show on map</button>
                    </span>
                  </div>

              </div>

              <div class="form-group">
                <label  for="file" >Choose a picture here </label><br />
                <label class="btn btn-warning" for="my-file-selector" >Choose file</label>
                <input id="my-file-selector" type="file" name="userfile"  size="20" style="display:none;" onchange="$('#upload-file-info').html($(this).val());"/>
                <span class='label label-info' id="upload-file-info"></span>
              </div>

              <div class="form-group">
                <label for="description" class="cols-sm-2 control-label">Description </label>
                <textarea rows="10" name="description" class="form-control" placeholder="Enter the description"></textarea><br />
              </div>

              <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Create an activity">

            </fieldset>
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div id="map_canvas" style="height:59.55em;">
      </div>
    </div>
  </div>
</body>
</html>
