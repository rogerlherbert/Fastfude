<?php $this->load->view('common/header'); ?>

	<?php echo form_open(); ?>
	<?php echo form_textarea(array('name' => 'post_text', 'value' => set_value('post_text', $post->post_text), 'rows' => '', 'cols' => '')); ?>
	<?php echo form_submit('post', 'Post'); ?>
	<?php echo form_close(); ?>

<?php $this->load->view('common/footer'); ?>