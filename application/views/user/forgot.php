<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<?php echo form_open(); ?>

	<div class="form-group<?php echo (form_error('username')) ? ' error' : '';?>">
		<?php echo form_label('username', 'username', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'username', 'class' => 'form-control', 'value' => set_value('username')); ?>
        <?php echo form_error('username','<span class="help-block">','</span>'); ?>
	</div>

	<?php echo form_button(array('type' => 'submit', 'content' => 'Email a reset link', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
