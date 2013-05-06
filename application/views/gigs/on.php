<?php $this->load->view('common/header'); ?>

<div class="span9 offset3">

<?php if (isset($gigs)) { ?>
	<?php if (count($gigs) > 0) { ?>
		<ol class="vcalendar unstyled media">

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

</div>

<?php $this->load->view('common/footer'); ?>