<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        html { height: 100%; }
        body { height: 50%; margin: 0px; padding: 0px; }
        #map_canvas { float:right; width:60%; height: 100%; margin: 0px auto; margin-top:20px;}
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
            mapTypeId : google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
        codeAddress();
    }
    function codeAddress()
    {
          var address = document.getElementById("address").value;
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

</head>


<body onload="initialize()">
    <div id="map_canvas">
    </div>
    <div>
    <input id="address" type="hidden" name="location" value="<?php echo $result['location_lng']?>" >
    </div>
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
    Comments:<br>

    <?php foreach ($comments as $comment_item): ?>
    <?php
      if($result['id'] === $comment_item['activity_id']){
        echo "User: ",$comment_item['email'],"&nbsp";
        echo "On: ",$comment_item['date'],"&nbsp", $comment_item['time'],"&nbsp", "<br>";
        echo "Said: ",$comment_item['comment'];
      }
    ?>
       <br><br>
    <?php endforeach; ?>





</body>
</html>
