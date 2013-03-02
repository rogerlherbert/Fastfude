<?php $this->load->view('common/header'); ?>

<div class="btn-group pull-right">
	<?php echo anchor('user/id/'.$profile->id, 'User profile', ' class="btn"'); ?>
	<?php echo anchor('user/posts/'.$profile->id, 'View posts', ' class="btn"'); ?>
</div>

<?php if (isset($posts)) { ?>
<ol class="posts unstyled">
<?php foreach ($posts as $post) { ?>
	<li id="post_<?php echo $post->id; ?>">
		<div class="post_meta">
			<p><?php echo anchor('topic/id/'.$post->topic_id.'#post_'.$post->id, $post->title); ?></p>
			<time datetime="<?php echo date("c", $post->post_time); ?>" class="comment_date"><?php echo date("D jS M Y, g:i a", $post->post_time); ?></time>
		</div>
		<div class="post_content">
			<?php echo nl2br(html_escape($post->post_text)); ?>
		</div>
	</li>

<?php } ?>
</ol>
<?php } else { ?>
<p>No posts made yet.</p>
<?php } ?>

<?php $this->load->view('common/footer'); ?>
