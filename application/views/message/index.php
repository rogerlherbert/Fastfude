<?php $this->load->view('common/header'); ?>

<div class="controls">
	<?php echo anchor('message/create', "Create a Private Message", ' class="button icon-plus"'); ?>
</div>

<?php if (count($messages) > 0) { ?>

<ol class="messages">
	<?php foreach ($messages as $user_id => $msg) { ?>
	<?php $class = ($msg['is_read'] == 0) ? ' class="unread"' : ''; ?>

	<li<?php echo $class; ?>>
		<?php echo anchor('message/with/'.$user_id, img(array('src' => 'http://www.gravatar.com/avatar/'.$msg['gravatar_id'].'?s=48', 'class' => 'avatar')) . html_escape($msg['username'])); ?>
		<p class="meta"><?php echo timespan($msg['post_time'], time(), 2); ?></p>
	</li>

	<?php } ?>
</ol>

<?php } else { ?>

	<p>No messages!</p>

<?php } ?>

<?php $this->load->view('common/footer'); ?>
