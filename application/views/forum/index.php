<?php $this->load->view('common/header'); ?>

<?php if (count($topics) > 0) { ?>

<ol>
<?php foreach ($topics as $topic) { ?>
	<li>
		<p class="topic_title"><?php echo $topic->title; ?></p>
		<p class="meta">
			<?php echo $topic->replies; ?> replies in FORUMNAME | 
			started by USER_FIRST, 
			last post by USER_LAST 
			<?php echo timespan($topic->post_time_last); ?> ago
		</p>
	</li>
<?php } ?>
</ol>

<?php } ?>

<?php $this->load->view('common/footer'); ?>
