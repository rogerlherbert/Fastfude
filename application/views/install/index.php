<h1>Install</h1>
<p>You'll need an empty database set up in /application/config/development/database.php</p>
<p>This installer will write a set of empty tables to it, overwriting any old copies of them and erasing their data.</p>

<?php echo form_open(); ?>
<?php echo form_submit('submit', 'Install'); ?>
<?php echo form_close(); ?>