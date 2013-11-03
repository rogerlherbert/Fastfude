<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<?php echo form_open(); ?>

	<div class="form-group<?php echo (form_error('password')) ? ' error' : '';?>">
		<?php echo form_label('New Password', 'password', array('class' => 'control-label')); ?>
        <?php echo form_password(array('name' => 'password', 'class' => 'form-control', 'value' => set_value('password'))); ?>
        <?php echo form_error('password','<span class="help-block">','</span>'); ?>
	</div>

	<div class="form-group<?php echo (form_error('passconf')) ? ' error' : '';?>">
		<?php echo form_label('Confirm New Password', 'passconf', array('class' => 'control-label')); ?>
        <?php echo form_password(array('name' => 'passconf', 'class' => 'form-control', 'value' => set_value('passconf'))); ?>
        <?php echo form_error('passconf','<span class="help-block">','</span>'); ?>
	</div>

    <?php echo form_button(array('type' => 'submit', 'content' => 'Reset Password', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
