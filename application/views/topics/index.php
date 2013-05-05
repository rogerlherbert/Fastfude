<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">
		<?php echo anchor('topic/create', '<i class="icon-plus"></i> Create a topic', ' class="btn btn-block"'); ?>	
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
