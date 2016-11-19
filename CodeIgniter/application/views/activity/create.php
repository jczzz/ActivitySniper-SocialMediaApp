<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/static/g_map_css.css">
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAnmxUGSXw3yYnu9tW-FLkaO1qGBb0pDfI&sensor=SET_TO_TRUE_OR_FALSE"></script>
    <script type="text/javascript" src="/static/g_map_js.js"></script>
    <?php echo $map['js']; ?>
</head>
<body onload="initialize()">
    <div>
    <?php echo validation_errors(); ?>
    <?php echo $error;?>
    <?php
      date_default_timezone_set("America/Vancouver");
    ?>
    <?php echo form_open_multipart("activity/create"); ?>

          <lable "activity name">Activity name: </lable><br />
          <input type="input" name="name" /><br />
          <lable "activity date">Activity date: </lable><br />
          <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" /><br />
          <lable "activity time">Activity time: </lable><br />
          <input type="time" name="time" value="<?php echo date('H:i'); ?>"/><br />
          <lable "catagory">Catagory: </lable><br />
          <input type="input" name="catagory" /><br />
          <lable "address">Address: </lable><br />
          <input type="text" name="address" id="myPlaceTextBox" />
          <input type="button" value="Show on map" onclick="codeAddress()"><br />
          <input type="file" name="userfile" size="20" /><br>
          <lable "description">Description: </lable><br />
          <textarea cols="40" rows="10" name="description"></textarea><br />

          <input type="submit" name="submit" value="Create an activity" >
    </form>
  </div>
  <div id="map_canvas">
  </div>

    <br><br><br>
</body>
</html>
