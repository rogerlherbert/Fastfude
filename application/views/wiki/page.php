<?php $this->load->view('common/header'); ?>

<div class="controls">
	<?php echo anchor('wiki/edit/'.$page->edit_id, "Edit this page", ' class="button icon-edit"'); ?>
</div>

<div class="wiki_text">
	<?php echo nl2br(html_escape($page->page_text)); ?>
</div>

<div class="wiki_meta">
	<p>last edited <?php echo date('D jS M Y, g:i a', $page->created); ?> by: <?php echo anchor('user/id/'.$page->user_id, $page->username); ?></p>
	<p>View the <?php echo anchor('wiki/history/'.$page->stub, 'edit history'); ?> of this page.</p>
</div>

<?php $this->load->view('common/footer'); ?>