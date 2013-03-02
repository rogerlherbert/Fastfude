</div>

<nav>
	<div class="menu"><i class="icon-reorder"></i>Fastfude</div>

	<div id="nav-wrapper">
		<?php echo form_open('search', array('class' => 'form-search')); ?>
		<?php echo form_hidden('type', 'forums'); ?>
		<?php echo form_input(array('name' => 'q', 'type' => 'search', 'placeholder' => 'Search Forums', 'class' => 'search-query')); ?>
		<?php echo form_close(); ?>
	
		<ul class="nav nav-list">
			<li><?php echo anchor('/', '<i class="icon-home"></i>Home', 'id="home" rel="home"'); ?></li>
			<li><?php echo anchor('gigs', '<i class="icon-music"></i>Gigs', 'id="nav_gigs"'); ?></li>
			<li><?php echo anchor('wiki', '<i class="icon-book"></i>Wiki', 'id="nav_wiki"'); ?></li>
			<li><?php echo anchor('messages', '<i class="icon-envelope-alt"></i>Messages', 'id="nav_messages"'); ?></li>
			<?php if ($this->session->userdata('user_id')) { ?>
			<li><?php echo anchor('settings', '<i class="icon-cog"></i>Settings', 'id="settings"'); ?></li>
			<li><?php echo anchor('user/sign_out', '<i class="icon-user"></i>Sign Out', 'id="signout"'); ?></li>
			<?php } else { ?>
			<li><?php echo anchor('user/sign_in', '<i class="icon-user"></i>Sign In', 'id="user"'); ?></li>
			<?php } ?>
		</ul>
	</div>
</nav>

<footer>
	<p id="linkage">Fastfude is on <?php echo anchor('https://twitter.com/fastfude', 'Twitter', ' class="icon-twitter-sign" rel="publisher"'); ?>, <?php echo anchor('https://facebook.com/fastfude', 'Facebook', ' class="icon-facebook-sign" rel="publisher"'); ?> &amp; <?php echo anchor('https://github.com/junap/Fastfude', 'Github', ' class="icon-github-sign" rel="publisher"'); ?></p>
	<p id="blurb">Scenewrecking since 1997</p>
</footer>

</body>
</html>
