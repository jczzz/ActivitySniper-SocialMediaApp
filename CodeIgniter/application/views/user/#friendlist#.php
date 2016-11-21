<?php foreach ($result as $friend_item): ?>
<a href="<?php echo site_url("user/information/".$friend_item['id']."/")?>"><?php echo $friend_item['email']; ?></a>
<br /><br />
<?php endforeach; ?>

<a href="<?php echo site_url("activity/index/SFU/")?>">Back to your activities</a>
