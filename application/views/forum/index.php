<?php $this->load->view('common/header'); ?>

<?php if (count($topics) > 0) { ?>

<ol>
<?php foreach ($topics as $topic) { ?>
	<li>
		<p class="topic_title"><?php echo anchor('topic/id/'.$topic->id, $topic->title); ?></p>
		<p class="meta">
			<?php echo $topic->replies; ?> replies in <?php echo $topic->forum_id; ?> | 
			started by <?php echo $topic->username_first; ?>, 
			last post by <?php echo $topic->username_last ?> 
			<?php echo timespan($topic->post_time_last); ?> ago
		</p>
	</li>
<?php } ?>
</ol>

<?php } ?>

<?php $this->load->view('common/footer'); ?>
