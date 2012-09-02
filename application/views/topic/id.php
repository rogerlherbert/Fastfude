<?php $this->load->view('common/header'); ?>

<?php echo $topic->title; ?>

<ol>
<?php foreach ($posts as $post) { ?>
	<li id="post_<?php echo $post->id; ?>">
		<div class="post_author">
			<?php echo img('http://www.gravatar.com/avatar/'.$post->gravatar_id); ?>
			<?php echo anchor('user/id/'.$post->user_id, html_escape($post->username)); ?>
			<?php echo date('c', $post->post_time); ?>
		</div>
		<div class="post_content">
			<?php echo nl2br(html_escape($post->post_text)); ?>
		</div>
	</li>

<?php } ?>
</ol>

<?php $this->load->view('common/footer'); ?>