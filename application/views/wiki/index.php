<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
		<li><?php echo anchor('wiki/create', 'Create a wiki page'); ?></li>
	</ul>
</div>

<div class="col-md-9">

<ol class="edit-history list-unstyled">
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