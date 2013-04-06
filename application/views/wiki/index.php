<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">
		<?php echo anchor('wiki/create', '<i class="icon-plus"></i> Create a wiki page', ' class="btn"'); ?>	
	</div>
</div>

<div class="span9">

<ol class="edit-history unstyled">
<?php foreach ($history as $edit) { ?>
	<li>
		<h3><?php echo anchor('wiki/page/'.$edit->stub.'/'.$edit->edit_id, '#'.$edit->edit_id . ': ' . $edit->title); ?></h3>
		<p><small>
			<span>Edited by <?php echo anchor('user/id/'.$edit->user_id, $edit->username); ?></span>
			<span><?php echo timespan($edit->created, time(), 2); ?> ago</span>
		</small></p>
	</li>
<?php } ?>
</ol>

</div>

<?php $this->load->view('common/footer'); ?>