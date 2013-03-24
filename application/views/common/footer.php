	</div>

	<nav class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<?php echo anchor('/', 'Fastfude', 'class="brand"'); ?>

				<div class="nav-collapse collapse">

					<?php echo form_open('search', array('class' => 'navbar-search pull-right')); ?>
					<?php echo form_hidden('type', 'forums'); ?>
					<?php echo form_input(array('name' => 'q', 'type' => 'search', 'placeholder' => 'Search Forums', 'class' => 'search-query')); ?>
					<?php echo form_close(); ?>
	
					<ul class="nav">
						<li><?php echo anchor('/', 'Home', 'id="home" rel="home"'); ?></li>
						<li><?php echo anchor('gigs', 'Gigs', 'id="nav_gigs"'); ?></li>
						<li><?php echo anchor('wiki', 'Wiki', 'id="nav_wiki"'); ?></li>
						<li><?php echo anchor('messages', 'Messages', 'id="nav_messages"'); ?></li>
						<li class="divider-vertical"></li>
						<?php if ($this->session->userdata('user_id')) { ?>
						<li class="dropdown">
							<?php echo anchor('user/id/'.$this->session->userdata('user_id'), 'Username <b class="caret"></b>', 'class="dropdown-toggle" data-toggle="dropdown"'); ?>
							<ul class="dropdown-menu">
								<li><?php echo anchor('settings', 'Settings', 'id="settings"'); ?></li>
								<li><?php echo anchor('user/sign_out', 'Sign Out', 'id="signout"'); ?></li>
							</ul>
						</li>
						<?php } else { ?>
						<li><?php echo anchor('user/sign_in', 'Sign In', 'id="user"'); ?></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</nav>

	<footer>
		<p id="linkage">Fastfude is on <?php echo anchor('https://twitter.com/fastfude', '<i class="icon-twitter-sign"></i>&nbsp;Twitter', 'rel="publisher"'); ?>, <?php echo anchor('https://facebook.com/fastfude', '<i class="icon-facebook-sign"></i>&nbsp;Facebook', 'rel="publisher"'); ?> &amp; <?php echo anchor('https://github.com/junap/Fastfude', '<i class="icon-github-sign"></i>&nbsp;Github', 'rel="publisher"'); ?></p>
		<p id="blurb">Scenewrecking since 1997</p>
	</footer>

</div>
</body>
</html>
