<?php $this->load->view('common/header'); ?>

<div class="controls">
	<?php echo anchor('gig/create', "Create a gig", ' class="button icon-plus"'); ?>
</div>

<?php if (isset($calendar)) { ?>
	<section class="calendar">
		<?php foreach ($calendar as $day_offset => $gigs) { ?>
			<?php $offset_time = time() + 86400 * $day_offset; ?>

			<?php echo heading(anchor('gig/on/'.date('Y-m-d', $offset_time), date('D d M', $offset_time)), 2) . "\n"; ?>

			<?php if (count($gigs) > 0) { ?>
				<ol class="vcalendar">

				<?php foreach ($gigs as $gig) { ?>
				<li class="vevent">
					<?php if ($gig->lineup != '') { ?>
						<div class="summary"><?php echo implode(' + ', unserialize($gig->lineup)); ?></div>
					<?php } ?>

					<?php if ($gig->topic_id != '') { ?>
						<div><?php echo anchor('topic/id/'.$gig->topic_id, $gig->gig_title, 'class="url"'); ?></div>
					<?php } elseif ($gig->gig_title != '') { ?>
						<div><?php echo $gig->gig_title; ?></div>
					<?php } ?>

					<span class="meta">
						<?php if ($gig->topic_id != '') { echo $gig->replies . " replies | "; } ?>
						<span class="location"><?php echo $gig->location; ?></span>
						Doors at <time class="dtstart" datetime="<?php echo date('c', $gig->start_time); ?>"></time>
					</span>
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