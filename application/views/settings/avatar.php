<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
		<li><?php echo anchor('settings/avatar', 'Avatar'); ?></li>
		<li><?php echo anchor('settings/email', 'Email'); ?></li>
		<li><?php echo anchor('settings/username', 'Username'); ?></li>
		<li><?php echo anchor('settings/password', 'Password'); ?></li>
		<li><?php echo anchor('settings/notifications', 'Notifications'); ?></li>
		<li><?php echo anchor('settings/delete', 'Delete Account'); ?></li>
	</ul>
</div>

<div class="col-md-9">

<?php echo form_open(); ?>

	<ul id="avatars" class="list-unstyled">
		<?php foreach ($options as $key => $service) { ?>
		<li class="field">
			<?php 
			$checked = ($this->session->userdata('avatar') && $key == $this->session->userdata('avatar')) ? TRUE : FALSE; 
			$label = form_radio('avatar', $service['value'], $checked);
			$label .= ($service['url'] != '') ? img(sprintf($service['url'], $this->session->userdata('avatar_hash'))) : '';
			$label .= ucfirst($key);
			?>
			<?php echo form_label($label, 'avatar', array('class' => 'radio')); ?>
		</li>

		<?php } ?>
	</ul>

	<?php echo form_error('avatar','<span class="form_error">','</span>'); ?>

	<?php echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
