<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">
		<?php echo (isset($watch_status)) ? anchor('topic/unwatch/'.$topic->id, '<i class="icon-bookmark-empty"></i> Stop watching', ' class="btn"') : anchor('topic/watch/'.$topic->id, '<i class="icon-bookmark"></i> Watch topic', ' class="btn"'); ?>
	</div>
</div>

<div class="span9">

<?php if (count($topics) > 0) { ?>

<ol class="topic-list unstyled">
<?php foreach ($topics as $topic) { ?>
	<li>
		<h3><?php echo anchor('topic/id/'.$topic->id, html_escape($topic->title)); ?></h3>
		<p><small>
			<?php echo ($topic->replies == 1) ? '1 reply' : $topic->replies.' replies'; ?> |
			last post by <?php echo anchor('user/id/'.$topic->user_id_last, html_escape($topic->username_last)); ?>, 
			<?php echo timespan($topic->post_time_last, time(), 2); ?> ago
		</small></p>
	</li>
<?php } ?>
</ol>

<?php } ?>

</div>

<?php $this->load->view('common/footer'); ?>
