<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">

	</div>
</div>

<div class="span9">

<?php echo form_open(); ?>

	<ul id="avatars" class="unstyled">
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

	<div class="form-actions">
		<?php echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>
	</div>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
