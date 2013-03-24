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

	<?php echo link_tag('assets/css/bootstrap.css'); ?>

	<?php echo link_tag('assets/css/bootstrap-responsive.css'); ?>

	<?php echo link_tag('assets/css/global.css'); ?>


	<script src="<?php echo base_url('assets/js/jquery-1.9.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/global.js'); ?>"></script>
</head>

<body class="<?php echo html_escape($bodyclass); ?>">
<div class="container-fluid">

	<header class="page-header">
		<div class="breadcrumb">
			<li><a href="#">Home</a> <span class="divider">/</span></li>
			<?php foreach ($breadcrumbs as $crumb => $segment) { ?>
			<li><a href="#"><?php echo $segment; ?></a> <span class="divider">/</span></li>
			<?php } ?>
		</div>

		<h1><?php echo html_escape($title); ?></h1>
	</header>
	
	<div role="main">
