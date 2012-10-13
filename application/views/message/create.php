<?php $this->load->view('common/header'); ?>

<?php echo form_open(); ?>

<div class="field dropdown">
	<?php echo form_label('User', 'user_id'); ?>
	<?php echo form_input(array('name' => 'user_id', 'value' => set_value('user_id', $user_id), 'type' => 'number')); ?>
	<?php echo form_error('user_id','<span class="form_error">','</span>'); ?>
</div>

<div class="field">
	<?php echo form_label('Text', 'post_text'); ?>
	<?php echo form_textarea('post_text', set_value('post_text')); ?>
	<?php echo form_error('post_text','<span class="form_error">','</span>'); ?>
</div>

<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Send Private Message', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>

<?php $this->load->view('common/footer'); ?>
