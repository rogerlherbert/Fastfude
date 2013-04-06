<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">
		<p><?php echo anchor('user/forgot', 'I forgot my password'); ?></p>
		<p><?php echo anchor('user/register', "Sign up for a new account"); ?></p>
	</div>
</div>

<div class="span9">

<?php echo form_open(); ?>

	<?php if(isset($error)) { echo "<span class=\"help-block\">".$error."</span>"; } ?>

	<div class="control-group<?php echo (form_error('username')) ? ' error' : '';?>">
		<?php echo form_label('username', 'username', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo form_input('username', set_value('username')); ?>
			<?php echo form_error('username','<span class="help-block">','</span>'); ?>
		</div>
	</div>

	<div class="control-group<?php echo (form_error('password')) ? ' error' : '';?>">
		<?php echo form_label('password', 'password', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo form_password('password', set_value('password')); ?>
			<?php echo form_error('password','<span class="help-block">','</span>'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Sign In', 'name' => 'sign_in', 'class' => 'btn btn-primary')); ?>
	</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
