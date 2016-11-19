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
