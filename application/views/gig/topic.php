<section class="vevent">
	<dl>
		<dt>Title</dt>
		<dd class="summary"><?php echo html_escape($gig->gig_title); ?></dd>
		<dt>Date</dt>
		<dd><time class="dtstart" datetime="<?php echo date("c", $gig->start_time); ?>"><?php echo anchor('gig/on/'.date('Y-m-d', $gig->start_time), date("D jS M Y, g:i a", $gig->start_time)); ?></time></dd>
		<dt>Location</dt>
		<dd class="location"><?php echo anchor('wiki/page/'.url_title(convert_accented_characters($gig->location)), html_escape($gig->location)); ?></dd>
		<dt>Lineup</dt>
		<dd class="description">
		<?php foreach ($gig->lineup as $band) { ?>
			<?php echo anchor('wiki/page/'.url_title(convert_accented_characters($band)), html_escape($band)); ?> + 
		<?php } ?>
		</dd>
	</dl>
	<div class="controls">
		<?php echo anchor('gig/edit/'.$gig->id, "Edit Gig", ' class="button icon-edit"'); ?>
	</div>
</section>