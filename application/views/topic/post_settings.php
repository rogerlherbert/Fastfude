<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">

	</div>
</div>

<div class="span9">

<dl>
	<dt>Topic</dt>
	<dd><?php echo anchor('topic/id/'. $post->topic_id, $post->title); ?></dd>

	<dt>Date</dt>
	<dd><?php echo date('D jS M Y, g:i a', $post->post_time); ?></dd>
	
	<dt>Author</dt>
	<dd><?php echo anchor('user/id/'. $post->user_id, $post->username); ?></dd>
</dl>

<div class="controls">
	<?php if ($this->session->userdata('user_id') == $post->user_id) { ?>
	<?php echo anchor('topic/edit_post/'. $post->id, '<i class="icon-edit"></i> Edit Post', 'class="button"'); ?>
	<?php } ?>
	<?php echo anchor('topic/flag_post/'. $post->id, '<i class="icon-flag"></i> Flag Post', 'class="button"'); ?>
	<?php echo anchor('message/to/'. $post->user_id, '<i class="icon-envelope-alt"></i> Message User', 'class="button"'); ?>
	<?php echo anchor('user/mute/'. $post->user_id, '<i class="icon-volume-off"></i> Mute User', 'class="button"'); ?>
</div>

</div>

<?php $this->load->view('common/footer'); ?>