<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">
		<?php echo anchor('topic/create', '<i class="icon-plus"></i> Create a topic', ' class="btn btn-block"'); ?>	
	</div>
</div>

<div class="span9">

<?php if (count($topics) > 0) { ?>

<ol class="topic-list unstyled">
<?php foreach ($topics as $topic) { ?>
	<li>
		<h3><?php echo anchor('topic/id/'.$topic->id, html_escape($topic->title)); ?></h3>
		<p><small>
			<?php echo ($topic->replies == 1) ? '1 reply' : $topic->replies.' replies'; ?>
			in <?php echo anchor('forum/id/'.$topic->forum_id, $forums[$topic->forum_id]); ?>
			| last post by <?php echo anchor('user/id/'.$topic->user_id_last, html_escape($topic->username_last)); ?> 
			<?php echo timespan($topic->post_time_last, time(), 2); ?> ago
		</small></p>
	</li>
<?php } ?>
</ol>

<?php } ?>

</div>

<?php $this->load->view('common/footer'); ?>
