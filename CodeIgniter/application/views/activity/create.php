<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        html { height: 100%; }
        body { height: 100%; margin: 0px; padding: 0px; }
        #map_canvas { float:right;width:70%; height: 70%; margin: 50px auto; margin-top:-450px }
    </style>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAnmxUGSXw3yYnu9tW-FLkaO1qGBb0pDfI&sensor=SET_TO_TRUE_OR_FALSE"></script>
    <script type="text/javascript">

    var geocoder;
    var map;
    function initialize()
    {
        geocoder = new google.maps.Geocoder();
        var myOptions = {
            zoom : 12,
            center : vancouver,
            mapTypeId : google.maps.MapTypeId.ROADMAP

        }
        map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
        codeAddress();
    }
    function codeAddress()
    {

          var address = document.getElementById("myPlaceTextBox").value;
          //地址解析
          geocoder.geocode({
              'address' : address
          }, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK)
              {
                  //依据解析的经度纬度设置坐标居中
                  map.setCenter(results[0].geometry.location);
                  var marker = new google.maps.Marker({
                      map : map,
                      position : results[0].geometry.location,
                      title : address,
                      //坐标动画效果
                      animation : google.maps.Animation.DROP
                  });
                  var display = "Location: " + results[0].formatted_address;
                  var infowindow = new google.maps.InfoWindow({
                      content : "<span style='font-size:11px'><b>name: </b>"
                              + address + "<br>" + display + "</span>",
                      //坐标偏移量，一般不用修改
                      pixelOffset : 0,
                      position : results[0].geometry.location
                  });
              //默认打开信息窗口,点击做伴弹出信息窗口

                    infowindow.open(map, marker);
                    google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });
              }
              else
              {
                    alert("Geocode was not successful for the following reason: " + status);
              }
          });
    }
    </script>
    <?php echo $map['js']; ?>
</head>
<body onload="initialize()">
    <div>
    <?php echo validation_errors(); ?>
    <?php echo $error;?>
    <?php
      date_default_timezone_set("America/Vancouver");
    ?>
    <?php echo form_open_multipart("activity/create/$user_id"); ?>

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
