<?php $this->load->view('common/header'); ?>

<div class="controls">
	<?php echo anchor('wiki/create', "Create a Wiki page", ' class="button icon-plus"'); ?>
</div>

<ol class="edit_history">
<?php foreach ($history as $edit) { ?>
	<li>
		<p class="wiki_title"><?php echo anchor('wiki/page/'.$edit->stub, $edit->title); ?></p>
		<p class="meta">
			<span>Edit <?php echo anchor('wiki/page/'.$edit->stub.'/'.$edit->edit_id , '#'.$edit->edit_id); ?></span>
			<span>made by <?php echo anchor('user/id/'.$edit->user_id, $edit->username); ?></span>
			<span><?php echo timespan($edit->created); ?> ago</span>
		</p>
	</li>
<?php } ?>
</ol>

<?php $this->load->view('common/footer'); ?>