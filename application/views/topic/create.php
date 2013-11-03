<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<?php echo form_open(); ?>

<div class="form-group<?php echo (form_error('subject')) ? ' error' : '';?>">
	<?php echo form_label('Subject', 'subject', array('class' => 'control-label')); ?>
    <?php echo form_input(array('name' => 'subject', 'class' => 'form-control', 'value' => set_value('subject')); ?>
    <?php echo form_error('subject','<span class="help-block">','</span>'); ?>
</div>

<div class="form-group<?php echo (form_error('post_text')) ? ' error' : '';?>">
	<?php echo form_label('Text', 'post_text', array('class' => 'control-label')); ?>
    <?php echo form_textarea(array('name' => 'post_text', 'class' => 'form-control', 'value' => set_value('post_text')); ?>
    <?php echo form_error('post_text','<span class="help-block">','</span>'); ?>
</div>

<div class="form-group<?php echo (form_error('tags')) ? ' error' : '';?>">
	<?php echo form_label('Tags', 'tags', array('class' => 'control-label')); ?>
    <?php echo form_input(array('name' => 'tags', 'class' => 'form-control', 'value' => set_value('tags')); ?>
    <?php echo form_error('tags','<span class="help-block">','</span>'); ?>
</div>

<?php echo form_button(array('type' => 'submit', 'content' => 'Create topic', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
