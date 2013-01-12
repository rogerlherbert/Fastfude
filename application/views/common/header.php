<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<title><?php echo html_escape($title); ?></title>

	<?php echo link_tag(array('href' => 'assets/img/touch-icon-114.png', 'rel' => 'apple-touch-icon', 'sizes' => '57x57')); ?>

	<?php echo link_tag(array('href' => 'assets/img/touch-icon-114.png', 'rel' => 'apple-touch-icon', 'sizes' => '114x114')); ?>

	<?php echo link_tag(array('href' => 'assets/img/touch-icon-144.png', 'rel' => 'apple-touch-icon', 'sizes' => '72x72')); ?>

	<?php echo link_tag(array('href' => 'assets/img/touch-icon-144.png', 'rel' => 'apple-touch-icon', 'sizes' => '144x144')); ?>


	<?php echo link_tag('assets/css/global.css'); ?>

	<?php echo link_tag('assets/css/font-awesome.min.css'); ?>


	<script src="<?php echo base_url('assets/js/jquery-1.8.3.min.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/global.js'); ?>" type="text/javascript"></script>
	<script type="text/javascript">$(document).ready(function() {global.init();});</script>
</head>

<body class="<?php echo html_escape($bodyclass); ?>">
<div id="content">

<div id="breadcrumbs">home > <?php echo strtolower(implode(' > ', $breadcrumbs)); ?>:</div>

<h1><?php echo html_escape($title); ?></h1>

