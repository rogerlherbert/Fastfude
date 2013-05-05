<div class="breadcrumb">
	<li><?php echo anchor('/', 'Home') ?> <span class="divider">/</span></li>

	<?php
	$i = 1;
	foreach ($breadcrumbs as $segment) 
	{
		if ($i == count($breadcrumbs)) 
		{
			echo '<li>'. $segment[0] .'</li>';
		}
		else
		{
			echo '<li>'. anchor(strtolower($segment[1]), $segment[0]) .' <span class="divider">/</span></li>';
		}
		
		$i++;
	}
	?>
</div>
