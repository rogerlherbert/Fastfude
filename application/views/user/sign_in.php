<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

	<div class="field" id="username">
		<?php echo form_label('username', 'username'); ?>
		<?php echo form_input('username', set_value('username')); ?>
		<?php echo form_error('username','<span class="form_error">','</span>'); ?>
	</div>

	<div class="field" id="password">
		<?php echo form_label('password', 'password'); ?>
		<?php echo form_password('password', set_value('password')); ?>
		<?php echo form_error('password','<span class="form_error">','</span>'); ?>
	</div>

	<div class="field" id="submit"><?php echo form_submit(array('name' => 'sign_in', 'value' => 'sign in', 'class' => 'button')); ?></div>

	<?php if(isset($error)) { echo "<p>".$error."</p>"; } ?>
	
	<?php echo anchor('user/forgot', 'Forgot Password'); ?>
<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
