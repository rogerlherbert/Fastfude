<?php $this->load->view('common/header'); ?>

<div class="span9 offset3">

<?php echo form_open(); ?>

<div class="control-group<?php echo (form_error('post_text')) ? ' error' : '';?>">
	<?php echo form_label('Text', 'post_text', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo form_textarea(array('name' => 'post_text', 'value' => set_value('post_text', $post->post_text), 'rows' => '8', 'cols' => '')); ?>
		<?php echo form_error('post_text','<span class="help-block">','</span>'); ?>
	</div>
</div>

<div class="form-actions">
	<?php echo form_button(array('type' => 'submit', 'content' => 'Create topic', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>