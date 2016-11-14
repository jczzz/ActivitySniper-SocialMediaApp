<?php echo validation_errors(); ?>
<?php echo form_open("activity/edit/$a_id/$u_id"); ?>
      <lable "activity name">Activity name: <lable><br />
      <input type="input" name="name" value="<?php echo $result['name']  ?>"/><br />
      <lable "activity date">Activity date: <lable><br />
      <input type="input" name="date"  value="<?php echo $result['date']  ?>"/><br />
      <lable "activity time">Activity time: <lable><br />
      <input type="input" name="time" value="<?php echo $result['time']  ?>"/><br />
      <lable "catagory">Catagory: <lable><br />
      <input type="input" name="catagory" value="<?php echo $result['catagory']  ?>"/><br />
      <lable "location_lng">Location lng: <lable><br />
      <input type="input" name="location_lng" value="<?php echo $result['location_lng']  ?>" /><br />
      <lable "location_lat">Location lat: <lable><br />
      <input type="input" name="location_lat" value="<?php echo $result['location_lat']  ?>"/><lable><br />
      <lable "description">Description: <lable><br />
      <textarea cols="40" rows="10" name="description" ><?php echo $result['description']?></textarea><br />

      <input type="submit" name="submit" value="Edit activity" >
</form>

<br><br><br>
