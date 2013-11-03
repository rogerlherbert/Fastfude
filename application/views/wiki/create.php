<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<?php echo form_open(); ?>

<div class="form-group<?php echo (form_error('title')) ? ' error' : '';?>">
	<?php echo form_label('Page title', 'title', array('class' => 'control-label')); ?>
    <?php echo form_input(array('name' => 'title', 'class' => 'form-control', 'value' => set_value('title'))); ?>
    <?php echo form_error('title','<span class="help-block">','</span>'); ?>
</div>

<div class="form-group<?php echo (form_error('page_text')) ? ' error' : '';?>">
	<?php echo form_label('Page text', 'page_text', array('class' => 'control-label')); ?>
    <?php echo form_input(array('name' => 'page_text', 'class' => 'form-control', 'value' => set_value('page_text'))); ?>
    <?php echo form_error('page_text','<span class="help-block">','</span>'); ?>
</div>

<?php echo form_button(array('type' => 'submit', 'content' => 'Create Wiki Page', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
