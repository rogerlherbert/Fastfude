<?php $this->load->view('common/header'); ?>

<div class="controls">
	<?php echo (isset($watch_status)) ? anchor('topic/unwatch/'.$topic->id, "Stop Watching", ' class="button icon-eye-close"') : anchor('topic/watch/'.$topic->id, "Watch", ' class="button icon-eye-open"'); ?>
</div>

<?php if (isset($gig)) {
	$this->load->view('gig/topic');
} ?>

<ol class="posts">
<?php foreach ($posts as $post) { ?>
	<li id="post_<?php echo $post->id; ?>">
		<?php if (in_array($post->user_id, $muted)) { ?>
			<p>You have muted <?php echo anchor('user/id/'.$post->user_id, $post->username); ?>.</p>
		<?php } elseif (in_array($post->id, $flagged)) { ?>
			<p>The community has muted this post by <?php echo anchor('user/id/'.$post->user_id, $post->username); ?></p>
		<?php } else { ?>

		<div class="post_author">
			<?php echo anchor('user/id/'.$post->user_id, img($post->avatar_url) . html_escape($post->username)); ?>
			<time datetime="<?php echo date("c", $post->post_time); ?>" class="comment_date"><?php echo date("D jS M Y, g:i a", $post->post_time); ?></time>
		</div>
		<div class="post_content">
			<?php echo nl2br(html_escape($post->post_text)); ?>
			<?php if ($post->edit_time != '') { ?>
			<p class="post_edit">last edited on <time><?php echo date('D jS M Y, g:i a', $post->edit_time); ?></time></p>
			<?php } ?>
		</div>
		<div class="controls">
		<?php if ($this->session->userdata('user_id') == $post->user_id) { ?>
			<?php echo anchor('topic/edit_post/'.$post->id, "Edit", ' class="button"'); ?>
		<?php } else { ?>
			<?php echo anchor('topic/flag_post/'.$post->id, "Flag", ' class="button"'); ?>
		<?php } ?>
		</div>

		<?php } ?>
	</li>

<?php } ?>
</ol>


<section class="reply">

	<h2>Post A Reply</h2>

	<?php echo form_open('topic/reply'); ?>
	<?php echo form_hidden('topic_id', $topic->id); ?>
	<?php echo form_textarea(array('name' => 'post_text', 'rows' => '', 'cols' => '')); ?>
	<?php echo form_submit('post', 'Post'); ?>
	<?php echo form_close(); ?>
</section>

<?php $this->load->view('common/footer'); ?>