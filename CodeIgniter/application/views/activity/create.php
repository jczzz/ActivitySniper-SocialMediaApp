<?php echo validation_errors(); ?>
<?php echo form_open("activity/create"); ?>
      <lable "activity name">Activity name: <lable><br />
      <input type="input" name="name" /><br />
      <lable "activity date">Activity date: <lable><br />
      <input type="input" name="date" /><br />
      <lable "activity time">Activity time: <lable><br />
      <input type="input" name="time" /><br />
      <lable "catagory">Catagory: <lable><br />
      <input type="input" name="catagory" /><br />
      <lable "location_lng">Location lng: <lable><br />
      <input type="input" name="location_lng" value="<?php echo $location ?>" /><br />
      <lable "location_lat">Location lat: <lable><br />
      <input type="input" name="location_lat" /><lable><br />
      <lable "description">Description: <lable><br />
      <textarea cols="40" rows="10" name="description"></textarea><br />

      <input type="submit" name="submit" value="Create an activity" >
</form>
