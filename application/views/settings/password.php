<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
			<li><?php echo anchor('settings/avatar', 'Avatar'); ?></li>
			<li><?php echo anchor('settings/email', 'Email'); ?></li>
			<li><?php echo anchor('settings/username', 'Username'); ?></li>
			<li><?php echo anchor('settings/password', 'Password'); ?></li>
			<li><?php echo anchor('settings/notifications', 'Notifications'); ?></li>
			<li><?php echo anchor('settings/delete', 'Delete Account'); ?></li>
		</ul>
	</div>
</div>

<div class="span9">

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

</div>

<?php $this->load->view('common/footer'); ?>
