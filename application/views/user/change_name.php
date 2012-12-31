<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

	<div class="field" id="username">
		<?php echo form_label('username', 'username'); ?>
		<?php echo form_input('username', set_value('username')); ?>
		<?php echo form_error('username','<span class="form_error">','</span>'); ?>
	</div>

	<div class="field" id="submit"><?php echo form_submit(array('name' => 'comfirm', 'value' => 'Save', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
