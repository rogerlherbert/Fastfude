<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

<div class="control-group<?php echo (form_error('password')) ? ' error' : '';?>">
	<?php echo form_label('New password', 'password', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo form_password('password', set_value('password')); ?>
		<?php echo form_error('password','<span class="help-block">','</span>'); ?>
	</div>
</div>

<div class="control-group<?php echo (form_error('passconf')) ? ' error' : '';?>">
	<?php echo form_label('Confirm new password', 'passconf', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo form_password('passconf', set_value('passconf')); ?>
		<?php echo form_error('passconf','<span class="help-block">','</span>'); ?>
	</div>
</div>

<div class="form-actions">
	<?php echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
