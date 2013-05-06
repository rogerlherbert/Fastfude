<?php $this->load->view('common/header'); ?>

<div class="span9 offset3">

<?php echo form_open(); ?>

	<div class="control-group<?php echo (form_error('username')) ? ' error' : '';?>">
		<?php echo form_label('username', 'username', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo form_input('username', set_value('username')); ?>
			<?php echo form_error('username','<span class="help-block">','</span>'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Email a reset link', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
	</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
