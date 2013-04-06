<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
			<li><?php echo anchor('settings/avatar', 'Avatar'); ?></li>
			<li><?php echo anchor('settings/email', 'Email'); ?></li>
			<li><?php echo anchor('settings/username', 'Username'); ?></li>
			<li><?php echo anchor('settings/password', 'Password'); ?></li>
			<li><?php echo anchor('settings/notifications', 'Notifications'); ?></li>
			<li><?php echo anchor('settings/delete', 'Delete Account'); ?></li>
		</ul>
	</div>
</div>

<div class="span9">

<?php echo form_open(); ?>

	<p>Get email notifications for:</p>
	
	<ul id="notifications" class="unstyled">
		<?php foreach ($options as $key => $label) { ?>
		<li class="field">
			<?php 
			$checked = (in_array($key, $settings)) ? TRUE : FALSE; 
			$input = form_checkbox('notifications[]', $key, $checked);
			?>
			<?php echo form_label($input . " " . $label, '', array('class' => 'checkbox')); ?>
		</li>
		<?php } ?>
	</ul>

	<?php echo form_error('notifications[]','<span class="form_error">','</span>'); ?>

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
	</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
