<div class="col-sm-6 col-sm-offset-3">
  <div class="panel panel-default">
    <div class="panel-body">
      <ul class="list-group">
        <?php foreach ($table as $tuples): ?>
          <li class="list-group-item">
            <a href="<?php echo site_url('user/information/'.$tuples['id']); //parameter for the 'view' function is this id?>">
            <?php echo $tuples['email'] ;?>
            </a>

            <?php
            if($tuples['id']==1)
            {
              echo '(admin)';
            }
            else
            {
              echo '(regular user)';
              echo "&nbsp","&nbsp",'<a class="btn btn-default" href="'.site_url('user/delete/'.$tuples['id']).'">Delete</a>';
            }
            ?>

          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
