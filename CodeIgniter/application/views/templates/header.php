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
  </head>
  <body>
    <?php
      if($this->session->userdata('logged_in')['id'] == 1){
        $default_URL = site_url("user/a_user");
      }else{
        $default_URL = site_url("activity/index/SFU/");
      }
    ?>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo $default_URL;?>">Activity Sniper</a>
        </div>
        <?php
          if($this->session->userdata('logged_in')['id'] != 1){
        ?>
          <ul class="nav navbar-nav">
              <li><a href="<?php echo site_url("activity/index/SFU/")?>">My Activities</a></li>
              <li><a href="<?php echo site_url("activity/showall/")?>">All Activities</a></li>
              <!--<li><a href="<?php echo site_url("user/friendlist")?>">Friend List</a></li>-->
              <li><a class="dropdown" data-toggle="dropdown" >Friend List<span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <?php
                        if(count($friend_result)>0){
                        ?>
                        <?php foreach ($friend_result as $friend_item): ?>
                        <li><a href="<?php echo site_url("user/information/".$friend_item['id']."/")?>"><?php echo $friend_item['email']; ?></a>
                        </li>
                        <?php endforeach; ?>
                        <?php
                         }
                         ?>
                         <?php
                         if(count($friend_result)==0){
                         ?>
                         <?php  echo "&nbsp","&nbsp","None"; ?>
                         <?php
                          }
                          ?>
                      </ul>
              </li>
            </ul>
        <?php
          }
        ?>
        <ul class="nav navbar-nav navbar-right">
          <?php
            if($this->session->userdata('logged_in')['id'] == 1){
              $default_URL = site_url("user/a_user");
              echo '<li><a href="'.$default_URL.'"><span class="glyphicon glyphicon-list-alt"></span> List All Users</a></li>';
            }
          ?>
          <li><a href="<?php echo site_url("user/checkinfor/");?>"><span class="glyphicon glyphicon-user"></span> View your account</a></li>
          <li><a href="<?php echo site_url("logout");?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
      </div>
    </nav>
    <h1><?php echo $title; ?></h1>
