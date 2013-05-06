<?php $this->load->view('common/header'); ?>

<div class="span9 offset3">

<?php echo form_open(); ?>

	<div class="control-group<?php echo (form_error('password')) ? ' error' : '';?>">
		<?php echo form_label('New Password', 'password', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo form_password('password', set_value('password')); ?>
			<?php echo form_error('password','<span class="help-block">','</span>'); ?>
		</div>
	</div>

	<div class="control-group<?php echo (form_error('passconf')) ? ' error' : '';?>">
		<?php echo form_label('Confirm New Password', 'passconf', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo form_password('passconf', set_value('passconf')); ?>
			<?php echo form_error('passconf','<span class="help-block">','</span>'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Reset Password', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
	</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
