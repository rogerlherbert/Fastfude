<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

	<ul id="avatars">
		<?php foreach ($options as $key => $service) { ?>
		<li class="field">
			<?php $checked = ($this->session->userdata('avatar') && $key == $this->session->userdata('avatar')) ? TRUE : FALSE; ?>
			<?php echo form_radio('avatar', $service['value'], $checked); ?>
			<?php echo ($service['url'] != '') ? img(sprintf($service['url'], $this->session->userdata('avatar_hash'))) : ''; ?>
			<?php echo form_label(ucfirst($key), 'avatar'); ?>
		</li>

		<?php } ?>
	</ul>
			<?php echo form_error('avatar','<span class="form_error">','</span>'); ?>

	<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Save', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
