<?php $this->load->view('common/header'); ?>

<ol class="posts">
<?php foreach ($messages as $post) { ?>
	<li id="post_<?php echo $post->id; ?>">
		<div class="post_author">
			<?php echo anchor('user/id/'.$post->user_id, img($post->avatar_url) . html_escape($post->username)); ?>
			<time datetime="<?php echo date("c", $post->post_time); ?>" class="comment_date"><?php echo date("D jS M Y, g:i a", $post->post_time); ?></time>
		</div>
		<div class="post_content">
			<?php if (isset($muted) && in_array($post->user_id, $muted)) {
				echo nl2br(html_escape("you have muted this user"));
			} else {
				echo nl2br(html_escape($post->post_text));
			}?>
		</div>
	</li>

<?php } ?>
</ol>


<section class="reply">

	<h2>Post A Reply</h2>

	<?php echo form_open('message/reply'); ?>
	<?php echo form_hidden('user_id', $user->id); ?>
	<?php echo form_textarea('post_text'); ?>
	<?php echo form_submit('post', 'Post'); ?>
	<?php echo form_close(); ?>
</section>

<?php $this->load->view('common/footer'); ?>