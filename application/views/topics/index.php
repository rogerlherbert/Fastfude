<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="sidebar-nav">
		<ul class="nav nav-tabs nav-stacked">
			<li><?php echo anchor('topic/create', 'Create a topic'); ?></li>
		</ul>
	</div>
</div>

<div class="span9">

<?php if (count($tags) > 0) { ?>
<ul class="inline">
<?php foreach ($tags as $tag) { ?>
	<?php echo '<li>'. anchor('topics/tagged/'.$tag->stub, $tag->stub) . ' <span class="badge">' . $tag->topic_count .'</span></li>'; ?>
<?php } ?>
</ul>
<?php } ?>

</div>

<?php $this->load->view('common/footer'); ?>
