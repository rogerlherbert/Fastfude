<?php $this->load->view('common/header'); ?>

<div class="controls">
	<?php echo anchor('wiki/create', "Create a Wiki page", ' class="button icon-plus"'); ?>
</div>

<ol>
<?php foreach ($history as $edit) { ?>
	<li>Edit <?php echo anchor('wiki/page/'.$edit->stub.'/'.$edit->edit_id , '#'.$edit->edit_id); ?> made to <?php echo anchor('wiki/page/'.$edit->stub, $edit->title); ?>, <?php echo timespan($edit->created); ?> ago by <?php echo anchor('user/id/'.$edit->user_id, $edit->username); ?></li>
<?php } ?>
</ol>

<?php $this->load->view('common/footer'); ?>