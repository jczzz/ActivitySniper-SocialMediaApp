<?php echo validation_errors(); ?>
<?php echo form_open_multipart("user/edit/$user_id");
//form data is for the create function,after submit, doing create function again with the new form input?>
        <lable for="Firstname">First name: (must needed)</lable><br />
        <input type="input" name="firstname" value="<?php echo $result['firstname'] ?>"/><br />

        <lable for="Lastname">Last name: (must needed)</lable><br />
        <input type="input" name="lastname" value="<?php echo $result['lastname'] ?>"/><br />

        <label for="password">Password: (must needed)</label><br />
        <input type="password" size="20" id="passowrd" name="password"/><br />

        <lable for="Email">Email: (must be unique,and needed)</lable><br />
        <input type="input" name="email" value="<?php echo $result['email'] ?>"/><br />

        <lable for="Phone Number">Phone Number: (XXX-XXX-XXXX)</lable><br />
        <input type="input" name="phonenum" value="<?php echo $result['phonenum'] ?>"/><br />

        <lable "file">Choose a picture: </lable><br />
        <input type="file" name="userfile" size="20" /><br>

        <lable for="Notes">Notes:</lable>  <br />
        <textarea cols="40" rows="10" name="notes"><?php echo $result['notes'] ?></textarea><br />

        <input type="submit" name="submit" value="Edit">
</form>
