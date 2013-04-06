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

<p>Pressing the button below will delete your account</p>

<p>This cannot be undone! Are you sure?</p>

<?php echo form_open(); ?>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Yes, Delete My Account', 'name' => 'confirm', 'class' => 'btn btn-danger')); ?>
	</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
