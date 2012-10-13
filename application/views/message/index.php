<?php $this->load->view('common/header'); ?>

<?php if (count($messages) > 0) { ?>

<ol class="messages">
	<?php foreach ($messages as $user_id => $msg) { ?>
	<?php $class = ($msg['is_read'] == 0) ? ' class="unread"' : ''; ?>

	<li<?php echo $class; ?>>
		<?php echo img(array('src' => 'assets/img/avatar_48.png', 'data-gravatar' => $msg['gravatar_id'], 'alt' => html_escape($msg['username']), 'class' => 'avatar small')); ?>
		<?php echo anchor('message/with/'.$user_id, html_escape($msg['username'])); ?>
		<span class="meta"><?php echo timespan($msg['post_time'], time(), 2); ?></span>
	</li>

	<?php } ?>
</ol>

<?php } else { ?>

	<p>No messages!</p>

<?php } ?>

<?php $this->load->view('common/footer'); ?>
