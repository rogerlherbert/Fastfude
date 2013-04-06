<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">

	</div>
</div>

<div class="span9">

<div class="btn-group">
	<?php echo anchor('wiki/create', '<i class="icon-plus"></i> Create a wiki page', ' class="btn"'); ?>	
</div>

<ol class="edit_history unstyled">
<?php foreach ($history as $edit) { ?>
	<li>
		<p class="wiki_title"><?php echo anchor('wiki/page/'.$edit->stub.'/'.$edit->edit_id, '#'.$edit->edit_id . ': ' . $edit->title); ?></p>
		<p class="meta">
			<span>Edited by <?php echo anchor('user/id/'.$edit->user_id, $edit->username); ?></span>
			<span><?php echo timespan($edit->created); ?> ago</span>
		</p>
	</li>
<?php } ?>
</ol>

</div>

<?php $this->load->view('common/footer'); ?>