<?php $this->load->view('common/header'); ?>
<?php echo form_open(); ?>

	<ul id="avatars">
		<li class="field">
			<?php echo form_radio('avatar', '', TRUE); ?>
			<?php echo form_label('None', 'avatar'); ?>
		</li>
	
		<li class="field">
			<?php echo form_radio('avatar', 'gravatar'); ?>
			<?php echo img('http://www.gravatar.com/avatar/'.$this->session->userdata('avatar_hash').'?s=96&r=pg'); ?>
			<?php echo form_label('Gravatar', 'avatar'); ?>
		</li>
		
		<li class="field">
			<?php echo form_radio('avatar', 'unicornify'); ?>
			<?php echo img('http://unicornify.appspot.com/avatar/'.$this->session->userdata('avatar_hash').'?s=96'); ?>
			<?php echo form_label('Unicornify', 'avatar'); ?>
		</li>
	</ul>
			<?php echo form_error('avatar','<span class="form_error">','</span>'); ?>

	<div class="field" id="submit"><?php echo form_submit(array('name' => 'confirm', 'value' => 'Save', 'class' => 'button')); ?></div>

<?php echo form_close(); ?>
<?php $this->load->view('common/footer'); ?>
