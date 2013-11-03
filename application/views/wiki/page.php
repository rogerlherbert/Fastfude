<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
		<li><?php echo anchor('wiki/edit/'.$page->edit_id, 'Edit this page'); ?></li>
		<li><?php echo anchor('wiki/history/'.$page->stub, 'History'); ?></li>
	</ul>
	<p>This version created on <time><?php echo date('D jS M Y, g:i a', $page->created); ?></time> by: <?php echo anchor('user/id/'.$page->user_id, $page->username); ?></p>
</div>

<div class="col-md-9">
	<?php echo Markdown($page->page_text); ?>
</div>

<?php $this->load->view('common/footer'); ?>