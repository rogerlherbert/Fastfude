<?php $this->load->view('common/header'); ?>

<ol class="edit_history">
<?php foreach ($history as $edit) { ?>
	<li>
		<p class="meta">
			<span>Edit <?php echo anchor('wiki/page/'.$page->stub.'/'.$edit->id , '#'.$edit->id); ?></span>
			<span>made by <?php echo anchor('user/id/'.$edit->user_id, $edit->username); ?></span>
			<span><?php echo timespan($edit->created); ?> ago</span>
		</p>
	</li>
<?php } ?>
</ol>

<?php $this->load->view('common/footer'); ?>