<?php $this->load->view('common/header'); ?>

<pre><?php echo var_dump($profile); ?></pre>

<?php echo anchor('user/mute/'.$profile->id, 'Mute user'); ?>

<?php $this->load->view('common/footer'); ?>