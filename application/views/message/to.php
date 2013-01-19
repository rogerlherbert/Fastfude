<?php $this->load->view('common/header'); ?>

<p>To: <?php echo anchor('user/id/'.$user->id, img($user->avatar_url) . html_escape($user->username)); ?></p>

<?php echo form_open(); ?>

<div class="field">
	<?php echo form_label('Text', 'post_text'); ?>
	<?php echo form_textarea('post_text', set_value('post_text')); ?>
	<?php echo form_error('post_text','<span class="form_error">','</span>'); ?>
</div>

<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Send Private Message', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>

<?php $this->load->view('common/footer'); ?>
