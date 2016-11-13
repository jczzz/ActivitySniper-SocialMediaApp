<?php echo validation_errors(); ?>
<?php echo form_open('user/create'); 
//form data is for the create function,after submit, doing create function again with the new form input?>
        <lable for="Firstname">First name: *</lable><br />
        <input type="input" name="firstname" /><br />

        <lable for="Lastname">Last name: *</lable><br />
        <input type="input" name="lastname" /><br />

        <label for="password">Password: *</label><br />
        <input type="password" size="20" id="passowrd" name="password"/><br />

        <lable for="Email">Email:</lable><br />
        <input type="input" name="email" /><br />

        <lable for="Phone Number">Phone Number:</lable><br />
        <input type="input" name="phonenum"><br />

        <lable for="Notes">Notes:</lable>  <br />
        <textarea cols="40" rows="10" name="notes"></textarea><br />






        
        
        <input type="submit" name="submit" value="Regisger">
</form>