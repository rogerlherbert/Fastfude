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

you'll get an email with a confirmation link shortly, click that link to continue deleting your account.

</div>

<?php $this->load->view('common/footer'); ?>
