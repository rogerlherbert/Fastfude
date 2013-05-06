<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="sidebar-nav">
		<ul class="nav nav-tabs nav-stacked">
			<li><?php echo anchor('wiki/edit/'.$page->edit_id, 'Edit this page'); ?></li>
			<li><?php echo anchor('wiki/history/'.$page->stub, 'History'); ?></li>
		</ul>
		<p>This version created on <time><?php echo date('D jS M Y, g:i a', $page->created); ?></time> by: <?php echo anchor('user/id/'.$page->user_id, $page->username); ?></p>
	</div>
</div>

<div class="span9">
	<?php echo nl2br(html_escape($page->page_text)); ?>
</div>

<?php $this->load->view('common/footer'); ?>