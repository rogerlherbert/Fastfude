<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
		<li><?php echo anchor('settings/avatar', 'Avatar'); ?></li>
		<li><?php echo anchor('settings/email', 'Email'); ?></li>
		<li><?php echo anchor('settings/username', 'Username'); ?></li>
		<li><?php echo anchor('settings/password', 'Password'); ?></li>
		<li><?php echo anchor('settings/notifications', 'Notifications'); ?></li>
		<li><?php echo anchor('settings/delete', 'Delete Account'); ?></li>
	</ul>
</div>

<div class="col-md-9">

<?php echo form_open(); ?>

<div class="form-group<?php echo (form_error('password')) ? ' error' : '';?>">
	<?php echo form_label('New password', 'password', array('class' => 'control-label')); ?>
    <?php echo form_password(array('name' => 'password', 'class' => 'form-control', 'value' => set_value('password'))); ?>
    <?php echo form_error('password','<span class="help-block">','</span>'); ?>
</div>

<div class="form-group<?php echo (form_error('passconf')) ? ' error' : '';?>">
	<?php echo form_label('Confirm new password', 'passconf', array('class' => 'control-label')); ?>
    <?php echo form_password(array('name' => 'passconf', 'class' => 'form-control', 'value' => set_value('passconf'))); ?>
    <?php echo form_error('passconf','<span class="help-block">','</span>'); ?>
</div>

<?php echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
