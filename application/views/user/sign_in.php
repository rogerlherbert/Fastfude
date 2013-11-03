<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
		<li><?php echo anchor('user/forgot', 'I forgot my password'); ?></li>
		<li><?php echo anchor('user/register', "Register a new account"); ?></li>
	</ul>
</div>

<div class="col-md-9">

<?php echo form_open(); ?>

	<?php if(isset($error)) { echo "<span class=\"help-block\">".$error."</span>"; } ?>

	<div class="form-group<?php echo (form_error('username')) ? ' error' : '';?>">
		<?php echo form_label('username', 'username', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'username', 'class' => 'form-control', 'value' => set_value('username'))); ?>
        <?php echo form_error('username','<span class="help-block">','</span>'); ?>
	</div>

	<div class="form-group<?php echo (form_error('password')) ? ' error' : '';?>">
		<?php echo form_label('password', 'password', array('class' => 'control-label')); ?>
        <?php echo form_password(array('name' => 'password', 'class' => 'form-control', 'value' => set_value('password'))); ?>
        <?php echo form_error('password','<span class="help-block">','</span>'); ?>
	</div>

	<?php echo form_button(array('type' => 'submit', 'content' => 'Sign In', 'name' => 'sign_in', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
