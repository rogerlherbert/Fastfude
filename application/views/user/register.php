<?php $this->load->view('common/header'); ?>

<div class="span9 offset3">

<?php echo form_open(); ?>

	<div class="control-group<?php echo (form_error('email')) ? ' error' : '';?>">
		<?php echo form_label('email', 'email', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo form_input(array('name' => 'email', 'value' => set_value('email'), 'type' => 'email')); ?>
			<?php echo form_error('email','<span class="help-block">','</span>'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Send confirmation email', 'name' => 'send_conf', 'class' => 'btn btn-primary')); ?>
	</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
