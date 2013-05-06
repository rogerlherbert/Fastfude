<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="sidebar-nav">
		<ul class="nav nav-tabs nav-stacked">
			<li><?php echo anchor('topic/create', 'Create a topic'); ?></li>
		</ul>
	</div>
</div>

<div class="span9">

<?php if (count($topics) > 0) { ?>

<ol class="topics">
<?php foreach ($topics as $topic) { ?>
	<li>
		<p class="topic_title"><?php echo anchor('topic/id/'.$topic->id, html_escape($topic->title)); ?></p>
		<p class="meta">
			<?php echo $topic->replies; ?> replies | 
			last post by <?php echo anchor('user/id/'.$topic->user_id_last, html_escape($topic->username_last)); ?> 
			<?php echo timespan($topic->post_time_last); ?> ago
		</p>
	</li>
<?php } ?>
</ol>

<?php } ?>

</div>

<?php $this->load->view('common/footer'); ?>
