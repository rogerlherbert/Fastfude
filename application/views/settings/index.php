<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">

	</div>
</div>

<div class="span9">

<ul>
	<li><?php echo anchor('settings/avatar', 'Avatar'); ?></li>
	<li><?php echo anchor('settings/email', 'Email'); ?></li>
	<li><?php echo anchor('settings/username', 'Username'); ?></li>
	<li><?php echo anchor('settings/password', 'Password'); ?></li>
	<li><?php echo anchor('settings/notifications', 'Notifications'); ?></li>
	<li><?php echo anchor('settings/delete', 'Delete Account'); ?></li>
</ul>

</div>

<?php $this->load->view('common/footer'); ?>
