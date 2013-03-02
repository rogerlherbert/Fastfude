<?php $this->load->view('common/header'); ?>

<?php if (isset($muted) && in_array($profile->id, $muted)) { ?>

<p>You have muted this user</p>

<?php echo anchor('user/unmute/'.$profile->id, 'Unmute user', ' class="btn btn-block"'); ?>

<?php } else { ?>

<p><?php echo img(array('src' => $profile->avatar_url, 'class' => 'img-polaroid avatar-large')); ?></p>

<?php if($profile->post_count > 0) { ?>
<p><?php echo anchor('user/posts/'.$profile->id, $profile->post_count . ' posts'); ?> since <?php echo date('M Y', $profile->first_post); ?></p>
<?php } else { ?>
<p>hasn't posted yet</p>
<?php } ?>

<?php echo anchor('message/to/'.$profile->id, 'Send a message', ' class="btn btn-block btn-primary"'); ?>
<?php echo anchor('user/mute/'.$profile->id, 'Mute user', ' class="btn btn-block btn-warning"'); ?>

<?php } ?>

<?php $this->load->view('common/footer'); ?>