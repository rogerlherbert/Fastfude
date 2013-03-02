<?php $this->load->view('common/header'); ?>

<div class="btn-group">
	<?php echo anchor('gigs/create', '<i class="icon-plus"></i> Create a gig', ' class="btn"'); ?>	
</div>

<?php if (isset($calendar)) { ?>
	<section class="calendar">
		<?php foreach ($calendar as $day_offset => $gigs) { ?>
			<?php $offset_time = time() + 86400 * $day_offset; ?>

			<?php echo heading(anchor('gigs/on/'.date('Y-m-d', $offset_time), date('D d M', $offset_time)), 2) . "\n"; ?>

			<?php if (count($gigs) > 0) { ?>
				<ol class="vcalendar unstyled">

				<?php foreach ($gigs as $gig) { ?>
				<li class="vevent">
					<?php if ($gig->topic_id != '') { ?>
						<div><?php echo anchor('topic/id/'.$gig->topic_id, $gig->gig_title, 'class="url"'); ?></div>
					<?php } elseif ($gig->gig_title != '') { ?>
						<div><?php echo $gig->gig_title; ?></div>
					<?php } ?>

					<?php if ($gig->lineup != '') { ?>
						<p class="meta summary"><?php echo $gig->lineup; ?></p>
					<?php } ?>
					
					<p class="meta">
						<?php if ($gig->topic_id != '') { echo $gig->replies . " replies | "; } ?>
						<span class="location"><?php echo $gig->location; ?></span>
						Doors at <time class="dtstart" datetime="<?php echo date('c', $gig->start_time); ?>"><?php echo date('h:i a', $gig->start_time); ?></time>
					</p>
				</li>
				<?php } ?>

				</ol>
			<?php } else { ?>

				<p class="vcalendar null">No gigs</p>

			<?php } ?>
		<?php } ?>
	</section>
<?php } ?>

<?php $this->load->view('common/footer'); ?>