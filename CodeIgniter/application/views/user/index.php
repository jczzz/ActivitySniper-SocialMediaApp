
<?php
	//needed variable for the index : $table
	//show all tuples with their links in this page
?>	

<?php foreach ($table as $tuples): ?>

    <?php echo"&nbsp" ?>
    <B>·</B>
    <a href="<?php echo site_url('user/'.$tuples['id']); //parameter for the 'view' function is this id?>">
    	<?php echo $tuples['lastname'],' ',$tuples['password'] ;?> 
    </a>
    <br/>

<?php endforeach; ?>




 <p><a href="http://localhost:9000/index.php/contacts/create">Add new contact</a></p>



