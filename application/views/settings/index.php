<?php $this->load->view('common/header'); ?>

<ul>
	<li><?php echo anchor('settings/avatar', 'Avatar'); ?></li>
	<li><?php echo anchor('settings/email', 'Email'); ?></li>
	<li><?php echo anchor('settings/username', 'Username'); ?></li>
	<li><?php echo anchor('settings/password', 'Password'); ?></li>
	<li><?php echo anchor('settings/notifications', 'Notifications'); ?></li>
	<li><?php echo anchor('settings/delete', 'Delete Account'); ?></li>
</ul>

<?php $this->load->view('common/footer'); ?>
