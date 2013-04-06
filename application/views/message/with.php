<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">

	</div>
</div>

<div class="span9">

<ol class="posts unstyled media-list">
<?php foreach ($messages as $post) { ?>
	<li id="post_<?php echo $post->id; ?>" class="media">

		<?php echo img(array('src' => $post->avatar_url, 'class' => 'pull-left avatar img-polaroid')); ?>

		<div class="media-body">
			<h4 class="media-heading">
				<?php echo anchor('user/id/'.$post->user_id, html_escape($post->username)); ?>
				<small><time datetime="<?php echo date("c", $post->post_time); ?>" class="comment_date"><?php echo date("D jS M Y, g:i a", $post->post_time); ?></time></small>
			</h4>

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

	<div class="control-group<?php echo (form_error('post_text')) ? ' error' : '';?>">
		<?php echo form_label('Text', 'post_text', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo form_textarea(array('name' => 'post_text', 'value' => set_value('post_text'), 'rows' => '8', 'cols' => '', 'class' => 'span12')); ?>
			<?php echo form_error('post_text','<span class="help-block">','</span>'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Send Message', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
	</div>

	<?php echo form_close(); ?>
</section>

</div>

<?php $this->load->view('common/footer'); ?>