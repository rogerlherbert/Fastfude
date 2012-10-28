<?php $this->load->view('common/header'); ?>

<div id="text">
	<?php echo nl2br(html_escape($page->page_text)); ?>
</div>

<p>last edited <?php echo $page->created; ?> by: <?php echo anchor('user/id/'.$page->user_id, $page->username); ?></p>

<p>View <?php echo anchor('wiki/history/'.$page->stub, 'full history'); ?></p>

<?php $this->load->view('common/footer'); ?>