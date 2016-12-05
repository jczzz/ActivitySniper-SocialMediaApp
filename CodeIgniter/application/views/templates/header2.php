<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->


    <!-- Bootstrap -->
    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <title>Activity Sniper</title>
    <style type="text/css">
        body
        {
           background-color:#f9f9f9;
        }
    </style>
  </head>
  <body>

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo site_url();?>">Activity Sniper</a>
        </div>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?php echo site_url("user/create");?>"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href="<?php echo site_url("user/login");?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
      </div>
    </nav>


    <?php if(isset($succ_info)){ ?>
        <div class="text-center alert alert-success"><?php echo $succ_info;?></div>
    <?php } ?>
