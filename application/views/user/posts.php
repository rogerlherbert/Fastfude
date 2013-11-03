<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul>
		<li><?php echo anchor('user/id/'.$profile->id, 'User profile'); ?></li>
		<li><?php echo anchor('user/posts/'.$profile->id, 'View posts'); ?></li>
	</ul>
</div>

<div class="col-md-9">

<?php if (isset($posts)) { ?>

<ol class="media-list">
<?php foreach ($posts as $post) { ?>
	<li id="post_<?php echo $post->id; ?>" class="media">
		<?php if ($this->session->userdata('user_id')) { ?>
			<?php echo anchor('topic/post_settings/'.$post->id, '<i class="icon-cog"></i>', 'title="Post settings" class="pull-right"'); ?>
		<?php } ?>

		<?php echo img(array('src' => $profile->avatar_url, 'class' => 'pull-left avatar')); ?>

		<article class="media-body">
			<h4 class="media-heading">
				<?php echo anchor('user/id/'.$post->user_id, html_escape($profile->username)); ?>
				<small><time datetime="<?php echo date("c", $post->post_time); ?>" class="comment_date meta"><?php echo date("D jS M Y, g:i a", $post->post_time); ?></time></small>
			</h4>

			<div class="post-text">
				<h4><small>posted in <?php echo anchor('topic/id/' . $post->topic_id . '#post_' . $post->id, $post->title); ?></small></h4>
				<?php echo nl2br(html_escape($post->post_text)); ?>
			</div>

			<?php if ($post->edit_time != '') { ?>
			<p class="post-edit">last edited on <time><?php echo date('D jS M Y, g:i a', $post->edit_time); ?></time></p>
			<?php } ?>
		</article>
	</li>

<?php } ?>
</ol>

<?php } else { ?>
<p>No posts made yet.</p>
<?php } ?>

</div>

<?php $this->load->view('common/footer'); ?>
