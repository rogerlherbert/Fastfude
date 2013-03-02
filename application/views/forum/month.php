<?php $this->load->view('common/header'); ?>

<div class="btn-group pull-right">
	<?php echo anchor('topic/create', '<i class="icon-plus"></i> Create a topic', ' class="btn"'); ?>
</div>

<?php if (count($topics) > 0) { ?>

<ol class="unstyled">
<?php foreach ($topics as $topic) { ?>
	<li>
		<p class="topic_title"><?php echo anchor('topic/id/'.$topic->id, html_escape($topic->title)); ?></p>
		<p class="meta">
			<?php echo ($topic->replies == 1) ? '1 reply' : $topic->replies.' replies'; ?> |
			started by <?php echo anchor('user/id/'.$topic->user_id_first, html_escape($topic->username_first)); ?> 
			at <?php echo date('g:ia \o\n D jS M, Y', $topic->post_time_first); ?>
		</p>
	</li>
<?php } ?>
</ol>

<?php } ?>

<?php $this->load->view('common/footer'); ?>
