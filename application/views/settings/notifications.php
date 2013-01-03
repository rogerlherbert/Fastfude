<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

	<p>Get email notifications for:</p>
	
	<ul id="notifications">
		<?php foreach ($options as $key => $label) { ?>
		<li class="field">
			<?php $checked = (in_array($key, $settings)) ? TRUE : FALSE; ?>
			<?php echo form_checkbox('notifications[]', $key, $checked); ?>
			<?php echo form_label($label); ?>
		</li>
		<?php } ?>
	</ul>

	<?php echo form_error('notifications[]','<span class="form_error">','</span>'); ?>

	<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Save', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
