<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<?php echo form_open(); ?>

	<div class="form-group<?php echo (form_error('email')) ? ' error' : '';?>">
		<?php echo form_label('email', 'email', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'email', 'class' => 'form-control', 'value' => set_value('email'), 'type' => 'email')); ?>
        <?php echo form_error('email','<span class="help-block">','</span>'); ?>
	</div>

	<?php echo form_button(array('type' => 'submit', 'content' => 'Send confirmation email', 'name' => 'send_conf', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
