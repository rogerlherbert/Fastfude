<?php $this->load->view('common/header'); ?>

<div class="span3">
	<div class="well sidebar-nav">

	</div>
</div>

<div class="span9">

<?php echo form_open(); ?>
<?php echo form_submit('post', 'Flag Post'); ?>
<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>