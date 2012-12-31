<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

	<div class="field" id="password">
		<?php echo form_label('New password', 'password'); ?>
		<?php echo form_password('password', set_value('password')); ?>
		<?php echo form_error('password','<span class="form_error">','</span>'); ?>
	</div>
	
	<div class="field" id="passconf">
		<?php echo form_label('Confirm password', 'passconf'); ?>
		<?php echo form_password('passconf', set_value('passconf')); ?>
		<?php echo form_error('passconf','<span class="form_error">','</span>'); ?>
	</div>
	
	<div class="field" id="submit"><?php echo form_submit(array('name' => 'comfirm', 'value' => 'Save', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
