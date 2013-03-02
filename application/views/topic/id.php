<?php $this->load->view('common/header'); ?>

<?php if (isset($gig)) {
	$this->load->view('gig/topic');
} ?>

<ol class="posts">
<?php foreach ($posts as $post) { ?>
	<li id="post_<?php echo $post->id; ?>">
		<?php if (in_array($post->user_id, $muted)) { ?>
			<p class="muted self">You have muted posts by <?php echo anchor('user/id/'.$post->user_id, $post->username); ?>.</p>
		<?php } elseif (in_array($post->id, $flagged)) { ?>
			<p class="muted community">The community has muted this post by <?php echo anchor('user/id/'.$post->user_id, $post->username); ?></p>
		<?php } else { ?>

		<div class="post_author">
			<?php if ($this->session->userdata('user_id')) { ?>
				<?php echo anchor('topic/post_settings/'.$post->id, '<i class="icon-cog"></i>', 'title="post settings" class="post_settings"'); ?>
			<?php } ?>
			<?php echo anchor('user/id/'.$post->user_id, img($post->avatar_url) . html_escape($post->username)); ?>
			<time datetime="<?php echo date("c", $post->post_time); ?>" class="comment_date meta"><?php echo date("D jS M Y, g:i a", $post->post_time); ?></time>
		</div>
		<div class="post_content">
			<?php echo nl2br(html_escape($post->post_text)); ?>
			<?php if ($post->edit_time != '') { ?>
			<p class="post_edit">last edited on <time><?php echo date('D jS M Y, g:i a', $post->edit_time); ?></time></p>
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

	<div class="control-group<?php echo (form_error('post_text')) ? ' error' : '';?>">
		<?php echo form_label('Text', 'post_text', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo form_textarea(array('name' => 'post_text', 'value' => set_value('post_text'), 'rows' => '8', 'cols' => '')); ?>
			<?php echo form_error('post_text','<span class="help-block">','</span>'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Post', 'name' => 'post', 'class' => 'btn btn-primary')); ?>
	</div>

	<?php echo form_close(); ?>
</section>

<div class="controls">
	<?php echo (isset($watch_status)) ? anchor('topic/unwatch/'.$topic->id, '<i class="icon-bookmark-empty"></i> Stop watching', ' class="button"') : anchor('topic/watch/'.$topic->id, '<i class="icon-bookmark"></i> Add topic to watchlist', ' class="button"'); ?>
</div>

<?php $this->load->view('common/footer'); ?>