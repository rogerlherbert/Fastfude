<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<p>To: <?php echo anchor('user/id/'.$user->id, img($user->avatar_url) . html_escape($user->username)); ?></p>

<?php echo form_open(); ?>

<div class="form-group<?php echo (form_error('post_text')) ? ' error' : '';?>">
	<?php echo form_label('Text', 'post_text', array('class' => 'control-label')); ?>
    <?php echo form_textarea(array('name' => 'post_text', 'class' => 'form-control', 'value' => set_value('post_text'), 'rows' => '8', 'cols' => '')); ?>
    <?php echo form_error('post_text','<span class="help-block">','</span>'); ?>
</div>

<?php echo form_button(array('type' => 'submit', 'content' => 'Send Message', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
