<?php $this->load->view('common/header'); ?>

<p>Pressing the button below will delete your account</p>

<p>This cannot be undone! Are you sure?</p>

<?php echo form_open(); ?>

	<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Yes, Delete My Account', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>

<?php $this->load->view('common/footer'); ?>
