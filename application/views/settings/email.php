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

	<div class="form-group<?php echo (form_error('email')) ? ' error' : '';?>">
		<?php echo form_label('New email address', 'email', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'email', 'class' => 'form-control', 'value' => set_value('email'), 'type' => 'email')); ?>
        <?php echo form_error('email','<span class="help-block">','</span>'); ?>
	</div>

	<?php echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
