<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

	<div class="field" id="email">
		<?php echo form_label('New Email Address', 'email'); ?>
		<?php echo form_input(array('name' => 'email', 'value' => set_value('email'), 'type' => 'email')); ?>
		<?php echo form_error('email','<span class="form_error">','</span>'); ?>
	</div>

	<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Save', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
