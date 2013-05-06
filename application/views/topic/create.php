<?php $this->load->view('common/header'); ?>

<div class="span9 offset3">

<?php echo form_open(); ?>

<div class="control-group<?php echo (form_error('subject')) ? ' error' : '';?>">
	<?php echo form_label('Subject', 'subject', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo form_input('subject', set_value('subject')); ?>
		<?php echo form_error('subject','<span class="help-block">','</span>'); ?>
	</div>
</div>

<div class="control-group<?php echo (form_error('post_text')) ? ' error' : '';?>">
	<?php echo form_label('Text', 'post_text', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo form_textarea('post_text', set_value('post_text')); ?>
		<?php echo form_error('post_text','<span class="help-block">','</span>'); ?>
	</div>
</div>

<div class="control-group<?php echo (form_error('tags')) ? ' error' : '';?>">
	<?php echo form_label('Tags', 'tags', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo form_input('tags', set_value('tags')); ?>
		<?php echo form_error('tags','<span class="help-block">','</span>'); ?>
	</div>
</div>

<div class="form-actions">
	<?php echo form_button(array('type' => 'submit', 'content' => 'Create topic', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
