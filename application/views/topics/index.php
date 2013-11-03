<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
		<li><?php echo anchor('topic/create', 'Create a topic'); ?></li>
	</ul>
</div>

<div class="col-md-9">

<?php if (count($tags) > 0) { ?>
<ul class="list-inline">
<?php foreach ($tags as $tag) { ?>
	<?php echo '<li>'. anchor('topics/tagged/'.$tag->stub, $tag->stub) . ' <span class="badge">' . $tag->topic_count .'</span></li>'; ?>
<?php } ?>
</ul>
<?php } ?>

</div>

<?php $this->load->view('common/footer'); ?>
