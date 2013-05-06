<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="sidebar-nav">
		<ul class="nav nav-tabs nav-stacked">
			<li><?php echo anchor('message/create', 'Create a message'); ?>	</li>
		</ul>
	</div>
</div>

<div class="span9">

<?php if (count($messages) > 0) { ?>

<ol class="messages unstyled">
	<?php foreach ($messages as $user_id => $msg) { ?>
	<?php $class = ($msg['is_read'] == 0) ? ' class="unread"' : ''; ?>

	<li<?php echo $class; ?>>
		<?php echo img(array('src' => $msg['avatar_url'], 'class' => 'avatar pull-left img-polaroid')); ?>
		<h3><?php echo anchor('message/with/'.$user_id, html_escape($msg['username'])); ?></h3>
		<p class="meta"><?php echo timespan($msg['post_time'], time(), 2); ?> ago</p>
	</li>

	<?php } ?>
</ol>

<?php } else { ?>

	<p>No messages!</p>

<?php } ?>

</div>

<?php $this->load->view('common/footer'); ?>
