<head><?php echo $map['js']; ?>

</head>
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
      <input type="text" name="address" id="myPlaceTextBox" /><br />
<input type="file" name="userfile" size="20" /><br>
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
