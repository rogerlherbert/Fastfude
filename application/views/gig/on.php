<?php $this->load->view('common/header'); ?>

<?php if (isset($gigs)) { ?>
	<?php if (count($gigs) > 0) { ?>
		<ol class="vcalendar">

		<?php foreach ($gigs as $gig) { ?>
		<li class="vevent">
			<?php if ($gig->lineup != '') { ?>
				<div class="summary"><?php echo $gig->lineup; ?></div>
			<?php } ?>

			<?php if ($gig->topic_id != '') { ?>
				<div><?php echo anchor('topic/id/'.$gig->topic_id, $gig->gig_title, 'class="url"'); ?></div>
			<?php } elseif ($gig->gig_title != '') { ?>
				<div><?php echo $gig->gig_title; ?></div>
			<?php } ?>

			<div class="meta">
				<?php if ($gig->topic_id != '') { echo "<p>" . $gig->replies . " replies</p>"; } ?>
				<p class="location"><?php echo $gig->location; ?></p>
				<p>Doors at <time class="dtstart" datetime="<?php echo date('c', $gig->start_time); ?>"><?php echo date('h:i a', $gig->start_time); ?></time></p>
			</div>
		</li>
		<?php } ?>

		</ol>
	<?php } else { ?>

		<p class="vcalendar null">No gigs</p>

	<?php } ?>
<?php } ?>

<?php $this->load->view('common/footer'); ?>