<?php $this->load->view('common/header'); ?>

<div class="col-md-offset-3">

<?php echo form_open(); ?>

	<div class="form-group<?php echo (form_error('start_time_1')) ? ' error' : '';?>">
		<?php echo form_label('Date', 'start_time_1', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'start_time_1', 'class' => 'form-control', 'value' => set_value('start_time_1', date('Y-m-d', $gig->start_time)), 'type' => 'date', 'min' => date('Y-m-d'), 'required' => 'required')); ?>
        <?php echo form_error('start_time_1','<span class="help-block">','</span>'); ?>
	</div>

	<div class="form-group<?php echo (form_error('start_time_2')) ? ' error' : '';?>">
		<?php echo form_label('Time', 'start_time_2', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'start_time_2', 'class' => 'form-control', 'value' => set_value('start_time_2', date('H:i', $gig->start_time)), 'type' => 'time')); ?>
        <?php echo form_error('start_time_2','<span class="help-block">','</span>'); ?>
	</div>

	<div class="form-group<?php echo (form_error('location')) ? ' error' : '';?>">
		<?php echo form_label('Venue', 'location', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'location', 'class' => 'form-control', 'value' => set_value('location', $gig->location))); ?>
        <?php echo form_error('location','<span class="help-block">','</span>'); ?>
	</div>

	<div class="form-group<?php echo (form_error('lineup')) ? ' error' : '';?>">
		<?php echo form_label('Lineup', 'lineup', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'lineup', 'class' => 'form-control', 'value' => set_value('lineup', $gig->lineup))); ?>
        <?php echo form_error('lineup','<span class="help-block">','</span>'); ?>
	</div>

	<div class="form-group<?php echo (form_error('subject')) ? ' error' : '';?>">
		<?php echo form_label('Subject', 'subject', array('class' => 'control-label')); ?>
        <?php echo form_input(array('name' => 'subject', 'class' => 'form-control', 'value' => set_value('subject', $gig->gig_title))); ?>
        <?php echo form_error('subject','<span class="help-block">','</span>'); ?>
	</div>

	<?php echo form_button(array('type' => 'submit', 'content' => 'Save', 'name' => 'confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

</div>

<?php $this->load->view('common/footer'); ?>
