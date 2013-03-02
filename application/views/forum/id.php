<?php $this->load->view('common/header'); ?>

<div class="btn-group pull-right">
	<?php echo anchor('topic/create', '<i class="icon-plus"></i> Create a topic', ' class="btn"'); ?>
</div>

<?php if (count($topics) > 0) { ?>

<ol class="unstyled">
<?php foreach ($topics as $topic) { ?>
	<li>
		<h3 class="topic_title"><?php echo anchor('topic/id/'.$topic->id, html_escape($topic->title)); ?></h3>
		<p class="meta">
			<?php echo ($topic->replies == 1) ? '1 reply' : $topic->replies.' replies'; ?> |
			last post by <?php echo anchor('user/id/'.$topic->user_id_last, html_escape($topic->username_last)); ?>, 
			<?php echo timespan($topic->post_time_last); ?> ago
		</p>
	</li>
<?php } ?>
</ol>

<?php } ?>

<p><?php echo anchor('forum/archive/'.$forum['id'], 'Browse the archive'); ?></p>

<?php $this->load->view('common/footer'); ?>
