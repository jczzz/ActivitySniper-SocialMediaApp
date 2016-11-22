<!DOCTYPE html>
<html>
<head>
  <!--  <link rel="stylesheet" type="text/css" href="/static/g_map_css.css">-->
    <!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAnmxUGSXw3yYnu9tW-FLkaO1qGBb0pDfI&sensor=SET_TO_TRUE_OR_FALSE"></script>-->
    <script type="text/javascript" src="/static/g_map_js.js"></script>
    <?php echo $map['js']; ?>

</head>
<body onload="initialize()">
  <div class="vertical-offset-100">
    <div class="col-sm-5">
      <div class="panel panel-default">
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
                    <span class="input-group-addon"><i class="glyphicon glyphicon-tag" aria-hidden="true"></i></span>
                    <input type="input" class="form-control" name="name"   value="<?php echo $result['name']  ?>"/>
                  </div>

              </div>

              <div class="form-group">
                <label for="activity date" class="cols-sm-2 control-label">Activity date</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar" aria-hidden="true"></i></span>
                    <input type="date" class="form-control" name="date"  value="<?php echo $result['date']  ?>"/>
                  </div>

              </div>

              <div class="form-group">
                <label for="activity time" class="cols-sm-2 control-label">Activity time</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time" aria-hidden="true"></i></span>
                    <input type="time" class="form-control" name="time"  value="<?php echo $result['time']  ?>"/>
                  </div>

              </div>

              <div class="form-group">
                <label for="catagory" class="cols-sm-2 control-label">Catagory</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-th-list" aria-hidden="true"></i></span>
                    <input type="input" class="form-control" name="catagory"  value="<?php echo $result['catagory']  ?>"/>
                  </div>

              </div>

              <div class="form-group">
                <label for="address" class="cols-sm-2 control-label">Address</label>

                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-flag" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="address" id="myPlaceTextBox" value="<?php echo $result['address']  ?>"/>
                    <span class="input-group-btn">
                      <button class="btn btn-info" type="button" onclick="codeAddress()" id="showOnMap">Show on map</button>
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
                <textarea rows="10" name="description" class="form-control" ><?php echo $result['description']?></textarea><br />
              </div>

              <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Edit activity">

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
