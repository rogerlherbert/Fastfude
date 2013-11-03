<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
		<li><?php echo (isset($watch_status)) ? anchor('topic/unwatch/'. $topic->id, 'Stop watching') : anchor('topic/watch/'.$topic->id, 'Watch topic'); ?></li>
		<li><?php echo anchor('topic/id/'. $topic->id .'#reply', 'Reply to topic'); ?></li>
		<?php echo (isset($gig)) ? '<li>'. anchor('gigs/edit/'.$gig->id, 'Edit gig details') . '</li>': ''; ?>
	</ul>
</div>

<div class="col-md-9">

<?php if (isset($gig)) {
	$this->load->view('gigs/topic');
} ?>

<ol class="media-list">
<?php foreach ($posts as $post) { ?>
	<li id="post_<?php echo $post->id; ?>" class="media">
		<?php if (in_array($post->user_id, $muted)) { ?>
			<p class="post-text muted by-user">You have muted posts by <?php echo anchor('user/id/'.$post->user_id, $post->username); ?>.</p>
		<?php } elseif (in_array($post->id, $flagged)) { ?>
			<p class="post-text muted by-community">The community has muted this post by <?php echo anchor('user/id/'.$post->user_id, $post->username); ?></p>
		<?php } else { ?>

		<?php if ($this->session->userdata('user_id')) { ?>
			<?php echo anchor('topic/post_settings/'.$post->id, '<i class="icon-cog"></i>', 'title="Post settings" class="pull-right"'); ?>
		<?php } ?>

		<?php echo img(array('src' => $post->avatar_url, 'class' => 'media-object')); ?>

		<article class="media-body">
			<h4 class="media-heading">
				<?php echo anchor('user/id/'.$post->user_id, html_escape($post->username)); ?>
				<small><time datetime="<?php echo date("c", $post->post_time); ?>" class="comment_date meta"><?php echo date("D jS M Y, g:i a", $post->post_time); ?></time></small>
			</h4>

			<div class="post-text"><?php echo nl2br(html_escape($post->post_text)); ?></div>

			<?php if ($post->edit_time != '') { ?>
			<p class="post-edit">last edited on <time><?php echo date('D jS M Y, g:i a', $post->edit_time); ?></time></p>
			<?php } ?>
		</article>

		<?php } ?>
	</li>

<?php } ?>
</ol>

<section id="reply">

	<h2>Post A Reply</h2>

	<?php echo form_open('topic/reply'); ?>

	<?php echo form_hidden('topic_id', $topic->id); ?>

	<div class="form-group<?php echo (form_error('post_text')) ? ' error' : '';?>">
		<?php echo form_label('Text', 'post_text', array('class' => 'control-label')); ?>
        <?php echo form_textarea(array('name' => 'post_text', 'class' => 'form-control', 'value' => set_value('post_text'), 'rows' => '8', 'cols' => '', 'class' => 'col-md-2')); ?>
        <?php echo form_error('post_text','<span class="help-block">','</span>'); ?>
	</div>

	<?php echo form_button(array('type' => 'submit', 'content' => 'Post', 'name' => 'post', 'class' => 'btn btn-primary')); ?>

	<?php echo form_close(); ?>
</section>

</div>

<?php $this->load->view('common/footer'); ?>