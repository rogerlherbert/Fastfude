<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

	<div id="email">
		<?php echo form_label('email', 'email'); ?>
		<?php echo form_input('email', set_value('email')); ?>
		<?php echo form_error('email','<span class="form_error">','</span>'); ?>
	</div>

	<div id="submit"><?php echo form_submit(array('name' => 'send_conf', 'value' => 'send confirmation email', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
