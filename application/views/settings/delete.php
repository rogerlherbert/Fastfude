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

<p>When you delete your account, here's what happens:</p>

<ul>
	<li>Your username will be reset to its ID number and your email, password and other user settings will all be deleted.</li>
	<li>Private messages you sent to others will be deleted. Their messages to you will not.</li>
	<li>Your public posts will not be deleted, but will no longer show your user details as the author.</li>
	<li>Gigs entries and Wiki pages don't have owners, but any historical edits will no longer show your user details as the author.</li>
	<li>Your browsing session on the site will be deleted and you will be logged out of Fastfude.</li>
</ul>

<p>You'll need to click a confirmation link via email to delete your account:</p>

<?php echo form_open(); ?>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Email Me A Delete Confirmation', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
	</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
