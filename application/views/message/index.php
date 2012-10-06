<?php $this->load->view('common/header'); ?>

<?php if (count($messages) > 0) { ?>

<ol class="messages">
	<?php foreach ($messages as $user_id => $msg) { ?>
	<?php $class = ($msg['is_read'] == 0) ? ' class="unread"' : ''; ?>
	<li<?php echo $class; ?>>
<?php echo "\t\t\t".img(array(
	'src' => 'assets/img/avatar_48.png',
	'data-gravatar' => $msg['gravatar_id'],
	'alt' => $msg['username'],
	'class' => 'avatar small'
)); ?>
		<?php echo anchor('messages/with/'.$user_id, $msg['username']); ?>
		<span class="meta"><?php echo timespan($msg['post_time'], time(), 2); ?></span>
	</li>
	<?php } ?>
</ol>

<?php } ?>

<?php $this->load->view('common/footer'); ?>
