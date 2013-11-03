<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<?php echo form_open(); ?>

	<div class="form-group<?php echo (form_error('username')) ? ' error' : '';?>">
		<?php echo form_label('Username', 'username', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'username', 'class' => 'form-control', 'value' => set_value('username'))); ?>
        <?php echo form_error('username','<span class="help-block">','</span>'); ?>
	</div>

	<div class="form-group<?php echo (form_error('password')) ? ' error' : '';?>">
		<?php echo form_label('Set a password', 'password', array('class' => 'control-label')); ?>
        <?php echo form_password(array('name' => 'password', 'class' => 'form-control', 'value' => set_value('password'))); ?>
        <?php echo form_error('password','<span class="help-block">','</span>'); ?>
	</div>

	<div class="form-group<?php echo (form_error('passconf')) ? ' error' : '';?>">
		<?php echo form_label('Confirm new password', 'passconf', array('class' => 'control-label')); ?>
        <?php echo form_password(array('name' => 'passconf', 'class' => 'form-control', 'value' => set_value('passconf'))); ?>
        <?php echo form_error('passconf','<span class="help-block">','</span>'); ?>
	</div>

	<?php echo form_button(array('type' => 'submit', 'content' => 'Confirm sign up', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
