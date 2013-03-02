<?php $this->load->view('common/header'); ?>

<?php echo form_open(); ?>

<div class="control-group<?php echo (form_error('title')) ? ' error' : '';?>">
	<?php echo form_label('Page title', 'title', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo form_input('title', set_value('title')); ?>
		<?php echo form_error('title','<span class="help-block">','</span>'); ?>
	</div>
</div>

<div class="control-group<?php echo (form_error('page_text')) ? ' error' : '';?>">
	<?php echo form_label('Page text', 'page_text', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo form_input('page_text', set_value('page_text')); ?>
		<?php echo form_error('page_text','<span class="help-block">','</span>'); ?>
	</div>
</div>

<div class="form-actions">
	<?php echo form_button(array('type' => 'submit', 'content' => 'Create Wiki Page', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo form_close(); ?>

<?php $this->load->view('common/footer'); ?>
