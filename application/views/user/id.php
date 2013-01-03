<?php $this->load->view('common/header'); ?>

<?php if (isset($muted) && in_array($profile->id, $muted)) { ?>

<p>You have muted this user</p>

<div class="controls">
	<?php echo anchor('user/unmute/'.$profile->id, 'Unmute user', ' class="button icon-volume-up"'); ?>
</div>

<?php } else { ?>

<?php echo img($profile->avatar_url); ?>

<div class="controls">
	<?php echo anchor('user/mute/'.$profile->id, 'Mute user', ' class="button icon-volume-off"'); ?>
	<?php echo anchor('user/posts/'.$profile->id, 'View posts', ' class="button icon-list"'); ?>
</div>

<?php } ?>

<?php $this->load->view('common/footer'); ?>