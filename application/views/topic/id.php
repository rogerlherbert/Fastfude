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
			<?php if ($muted && in_array($post->user_id, $muted)) {
				echo nl2br(html_escape("you have muted this user"));
			} else {
				echo nl2br(html_escape($post->post_text));
			}?>
		</div>
	</li>

<?php } ?>
</ol>

<section>
	<?php echo form_open('topic/reply'); ?>
	<?php echo form_hidden('topic_id', $topic->id); ?>
	<?php echo form_textarea('post_text'); ?>
	<?php echo form_submit('post', 'Post'); ?>
	<?php echo form_close(); ?>
</section>

<?php $this->load->view('common/footer'); ?>