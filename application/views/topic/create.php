<?php $this->load->view('common/header'); ?>

<?php echo form_open(); ?>

<div class="field dropdown">
	<?php echo form_label('Forum', 'forum_id'); ?>
	<?php echo form_dropdown('forum_id', $forums); ?>
	<?php echo form_error('forum_id','<span class="form_error">','</span>'); ?>
</div>

<div class="field">
	<?php echo form_label('Subject', 'subject'); ?>
	<?php echo form_input('subject', set_value('subject')); ?>
	<?php echo form_error('subject','<span class="form_error">','</span>'); ?>
</div>

<div class="field">
	<?php echo form_label('Text', 'post_text'); ?>
	<?php echo form_textarea('post_text', set_value('post_text')); ?>
	<?php echo form_error('post_text','<span class="form_error">','</span>'); ?>
</div>

<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Create Topic', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>

<?php $this->load->view('common/footer'); ?>
