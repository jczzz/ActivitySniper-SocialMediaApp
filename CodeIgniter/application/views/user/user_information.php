<div class="col-sm-6 col-sm-offset-3">
  <div class="panel panel-default">
    <div class="panel-body">
      <ul class="list-group">
        <img src="/static/<?php echo $result['picture'];?>" class="img-thumbnail center-block">
        <br>
        <li class="list-group-item"><label for="Email" class="cols-sm-2 control-label">Email:</label><br >
          <?php  echo "&nbsp","&nbsp",$result['email'];?><br />
        </li>

        <li class="list-group-item"><label for="Phone number" class="cols-sm-2 control-label">Phone number:</label><br >
          <?php  echo "&nbsp","&nbsp",$result['phonenum'];?><br />
        </li>

        <li class="list-group-item"><label for="Notes" class="cols-sm-2 control-label">Notes:</label><br >
          <?php  echo "&nbsp","&nbsp",$result['notes'];?><br />
        </li>
        <li class="list-group-item text-center"><a class="btn btn-default" href="<?php echo site_url("user/edit/");?>">Edit your account</a></li>
      </ul>
    </div>
  </div>
</div>
