<?php $this->load->view('common/header'); ?>

<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked">
		<li><?php echo anchor('gigs/create', 'Create a gig'); ?></li>
	</ul>
</div>

<div class="col-md-9">

<?php if (isset($calendar)) { ?>
	<section class="calendar media-list">
		<?php foreach ($calendar as $day_offset => $gigs) { ?>
			<?php $offset_time = time() + 86400 * $day_offset; ?>

			<?php echo heading(anchor('gigs/on/'.date('Y-m-d', $offset_time), date('D d M', $offset_time)), 2) . "\n"; ?>

			<?php if (count($gigs) > 0) { ?>
				<ol class="vcalendar list-unstyled media">

				<?php foreach ($gigs as $gig) { ?>
				<li class="vevent media-body">
					<?php if ($gig->lineup != '') { ?>
						<h3 class="summary media-title"><?php echo $gig->lineup; ?></h3>
					<?php } else { ?>
						<h3 class="summary media-title"><?php echo $gig->title; ?></h3>
					<?php } ?>
					
					<p><small>
						<?php if ($gig->topic_id != '') { echo anchor('topic/id/'.$gig->topic_id, $gig->replies . " replies", 'class="url"') . " | "; } ?>
						<span class="location"><?php echo $gig->location; ?></span>
						Doors at <time class="dtstart" datetime="<?php echo date('c', $gig->start_time); ?>"><?php echo date('h:i a', $gig->start_time); ?></time>
					</small></p>
				</li>
				<?php } ?>

				</ol>
			<?php } else { ?>

				<p class="vcalendar null">No gigs</p>

			<?php } ?>
		<?php } ?>
	</section>
<?php } ?>

</div>

<?php $this->load->view('common/footer'); ?>