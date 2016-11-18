<?php
	//needed variable for the view : $contacts_item
	//show all tuples with their links in this page
?>

<?php if ($contacts_item ===null )//if the $id is not found, then show 404
	  {show_404();}
?>

First name:<br/>
	<?php  echo "&nbsp", "&nbsp",$contacts_item['firstname'];?> <br/>
Last name:<br/>
	<?php  echo "&nbsp", "&nbsp", $contacts_item['lastname'];?> <br/>
Email:<br/>
	<?php  echo "&nbsp", "&nbsp", $contacts_item['email'];?> <br/>
Phone Number:<br/>
	<?php  echo "&nbsp", "&nbsp", $contacts_item['phonenum'];?> <br/>
Notes:<br/>
	<?php  echo "&nbsp", "&nbsp",$contacts_item['notes'];?> <br/>
Password:<br/>
	<?php  echo "&nbsp", "&nbsp",$contacts_item['password'];?> <br/>

<a href="http://localhost:9000/user/a_user">Back to admin page</a>
<br/>
