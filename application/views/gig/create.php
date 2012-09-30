<?php $this->load->view('common/header'); ?>

<?php echo form_open(); ?>

<div class="field">
	<?php echo form_label('Date', 'start_time_1'); ?>
	<?php echo form_input(array('name' => 'start_time_1', 'value' => set_value('start_time_1'), 'type' => 'date')); ?>
	<?php echo form_error('start_time_1','<span class="form_error">','</span>'); ?>
</div>

<div class="field">
	<?php echo form_label('Time', 'start_time_2'); ?>
	<?php echo form_input(array('name' => 'start_time_2', 'value' => set_value('start_time_2'), 'type' => 'time')); ?>
	<?php echo form_error('start_time_2','<span class="form_error">','</span>'); ?>
</div>

<div class="field">
	<?php echo form_label('Venue', 'location'); ?>
	<?php echo form_input('location', set_value('location')); ?>
	<?php echo form_error('location','<span class="form_error">','</span>'); ?>
</div>

<div class="field">
	<?php echo form_label('Lineup', 'lineup'); ?>
	<?php echo form_input('lineup', set_value('lineup')); ?>
	<?php echo form_error('lineup','<span class="form_error">','</span>'); ?>
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

<div class="field" id="submit"><?php echo form_submit(array('name' => 'comfirm', 'value' => 'Create Gig', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>

<?php $this->load->view('common/footer'); ?>
