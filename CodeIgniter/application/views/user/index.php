
<?php
	//needed variable for the index : $table
	//show all tuples with their links in this page
?>

<?php foreach ($table as $tuples): ?>

    <?php echo"&nbsp"; ?>
    <B>·</B>
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
		}

	?>


	<a href="<?php echo site_url('user/delete/'.$tuples['id']);?>">delete</a>





    <br/>

<?php endforeach; ?>
