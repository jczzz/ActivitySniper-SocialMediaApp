<img src="/static/<?php echo $result['picture'];?>" ><br />
Email:<?php echo "&nbsp",$result['email'];?> <br /><br /><br /><br />
Phone number:<?php echo "&nbsp",$result['phonenum']; ?><br /><br /><br /><br />
Introduction:<?php echo "&nbsp",$result['notes']; ?><br /><br /><br /><br />


<a href="<?php echo site_url("activity/index/sfu/".$user_id);?>">Back to your activities</a>|<a href="<?php echo site_url("user/edit/".$user_id);?>">Edit your account</a>
