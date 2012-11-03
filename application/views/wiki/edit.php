<?php $this->load->view('common/header'); ?>

<?php echo form_open(); ?>

<div class="field">
	<?php echo form_label('Page Title', 'title'); ?>
	<?php echo form_input('title', set_value('title', $page->title)); ?>
	<?php echo form_error('title','<span class="form_error">','</span>'); ?>
</div>

<div class="field">
	<?php echo form_label('Page Text', 'page_text'); ?>
	<?php echo form_textarea('page_text', set_value('page_text', $page->page_text)); ?>
	<?php echo form_error('page_text','<span class="form_error">','</span>'); ?>
</div>

<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Save Changes', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>

<?php $this->load->view('common/footer'); ?>
