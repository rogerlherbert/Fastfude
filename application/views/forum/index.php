<?php $this->load->view('common/header'); ?>

<?php if (count($topics) > 0) { ?>

<ol class="unstyled">
<?php foreach ($topics as $topic) { ?>
	<li>
		<h3 class="topic_title"><?php echo anchor('topic/id/'.$topic->id, html_escape($topic->title)); ?></h3>
		<p class="meta">
			<?php echo $topic->replies; ?> replies in <?php echo anchor('forum/id/'.$topic->forum_id, $forums[$topic->forum_id]); ?> | 
			last post by <?php echo anchor('user/id/'.$topic->user_id_last, html_escape($topic->username_last)); ?> 
			<?php echo timespan($topic->post_time_last); ?> ago
		</p>
	</li>
<?php } ?>
</ol>

<?php } ?>

<?php $this->load->view('common/footer'); ?>
