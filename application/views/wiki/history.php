<?php $this->load->view('common/header'); ?>

<ol>
<?php foreach ($history as $edit) { ?>
	<li>Edit <?php echo anchor('wiki/page/'.$page->stub.'/'.$edit->id , '#'.$edit->id); ?> made <?php echo timespan($edit->created); ?> ago by <?php echo anchor('user/id/'.$edit->user_id, $edit->username); ?></li>
<?php } ?>
</ol>

<?php $this->load->view('common/footer'); ?>