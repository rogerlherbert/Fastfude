<section class="vevent">
	<dl>
		<dt>Title</dt>
		<dd class="summary"><?php echo html_escape($gig->gig_title); ?></dd>
		<dt>Date</dt>
		<dd><time class="dtstart" datetime="<?php echo date("c", $gig->start_time); ?>"><?php echo date("D jS M Y, g:i a", $gig->start_time); ?></time></dd>
		<dt>Location</dt>
		<dd class="location"><?php echo html_escape($gig->location); ?></dd>
		<dt>Lineup</dt>
		<dd class="description"><?php echo html_escape($gig->lineup); ?></dd>
	</dl>
</section>