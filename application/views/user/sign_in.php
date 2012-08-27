<?php echo form_open(); ?>

	<div id="username">
		<?php echo form_label('username or email', 'username'); ?>
		<?php echo form_input('username', set_value('username')); ?>
		<?php echo form_error('username','<span class="form_error">','</span>'); ?>
	</div>

	<div id="password">
		<?php echo form_label('password', 'password'); ?>
		<?php echo form_password('password', set_value('password')); ?>
		<?php echo form_error('password','<span class="form_error">','</span>'); ?>
	</div>

	<div id="submit"><?php echo form_submit(array('name' => 'sign_in', 'value' => 'sign in', 'class' => 'button')); ?></div>

	<?php if(isset($error)) { echo "<p>".$error."</p>"; } ?>
<?php echo form_close(); ?>