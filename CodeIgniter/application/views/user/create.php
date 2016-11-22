<style>
  h1
  {
     text-align:center
  }
</style>
<h1>Sign Up</h1>
<div class="row vertical-offset-100">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Please Sign up</h3>
    </div>
      <div class="panel-body">
        <div class="list-group-item-danger">
          <?php echo validation_errors(); ?>
          <?php echo $error;?>
        </div>
  <?php echo form_open_multipart('user/create'); ?>
        <form accept-charset="UTF-8" role="form">
            <fieldset>
              <div class="form-group">
              <label for="Firstname" class="cols-sm-2 control-label">First name: (required)</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                  <input type="input" class="form-control" name="firstname"  placeholder="Enter your Firstname"/>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="Lastname" class="cols-sm-2 control-label">Last name: </label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                  <input type="input"  class="form-control" name="lastname"  placeholder="Enter your Lastname"/>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="cols-sm-2 control-label">Password: (required)</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
                  <input type="password" size="20" id="passowrd" name="password"  class="form-control" placeholder="Enter your Password"/>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="Email" class="cols-sm-2 control-label">Email: (must be unique,and required)</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i></span>
                  <input type="input" name="email"  class="form-control" placeholder="Enter your Email"/>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="Phone Number" class="cols-sm-2 control-label">Phone Number: (XXX-XXX-XXXX)</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i></span>
                  <input type="input" name="phonenum"  class="form-control" placeholder="Enter your Phone number"/>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label  for="file" >Choose a picture here :</label><br />
              <label class="btn btn-warning" for="my-file-selector" >Choose file</label>
                <input id="my-file-selector" type="file" name="userfile"  size="20" style="display:none;" onchange="$('#upload-file-info').html($(this).val());"/>

                <span class='label label-info' id="upload-file-info"></span>
            </div>

            <div class="form-group">
              <label for="Notes" class="cols-sm-2 control-label">Notes: </label>
                  <textarea cols="40" rows="3" name="notes" class="form-control"></textarea><br />
            </div>
          <input class="btn btn-lg btn-success btn-block" type="submit" value="Sign up">
            </fieldset>
          </form>
      </div>
  </div>
</div>
</div>
