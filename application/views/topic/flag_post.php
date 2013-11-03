<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<?php echo form_open(); ?>
<?php echo form_submit('post', 'Flag Post'); ?>
<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>