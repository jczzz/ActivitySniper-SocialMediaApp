<head><?php echo $map['js']; ?>

</head>

<?php echo validation_errors(); ?>
<?php echo form_open("activity/create/$location/$user_id"); ?>
      <lable "activity name">Activity name: </lable><br />
      <input type="input" name="name" /><br />
      <lable "activity date">Activity date: </lable><br />
      <input type="input" name="date" /><br />
      <lable "activity time">Activity time: </lable><br />
      <input type="input" name="time" /><br />
      <lable "catagory">Catagory: </lable><br />
      <input type="input" name="catagory" /><br />
      <lable "location_lng">Location lng: </lable><br />
      <input  type="input" id="location" name="location_lng" /><br />
      <lable "location_lat">Location lat: </lable><br />
      <input type="input" name="location_lat" /></lable><br />

      <lable "placeBox">Address: </lable><br />
      <input type="text" id="myPlaceTextBox" /><br />

      <lable "description">Description: </lable><br />
      <textarea cols="40" rows="10" name="description"></textarea><br />

      <input type="submit" name="submit" value="Create an activity" >
</form>

<br><br><br>


<!--
<script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	function change_location()
	{
		var loc=$(this).val();
		document.getElementById("location").value=loc;
	}
	$('#myPlaceTextBox').on('keyup',change_location);
  $('#myPlaceTextBox').on('mouseleave',change_location);
  $('#myPlaceTextBox').on('mouseenter',change_location);
});
</script>
-->
 <?php echo $map['html']; ?>
