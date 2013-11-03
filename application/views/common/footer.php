		</div>
	</div>

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php echo anchor('/', 'Fastfude', 'class="navbar-brand" rel="home"'); ?>
		</div>

		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li><?php echo anchor('topics', 'Topics', 'id="nav_topics"'); ?></li>
				<li><?php echo anchor('gigs', 'Gigs', 'id="nav_gigs"'); ?></li>
				<li><?php echo anchor('wiki', 'Wiki', 'id="nav_wiki"'); ?></li>
				<li><?php echo anchor('messages', 'Messages', 'id="nav_messages"'); ?></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<?php if ($this->session->userdata('user_id')) { ?>
				<li class="dropdown">
					<?php echo anchor('user/id/'.$this->session->userdata('user_id'), $this->session->userdata('username') . ' <b class="caret"></b>', 'class="dropdown-toggle" data-toggle="dropdown"'); ?>
					<ul class="dropdown-menu">
						<li><?php echo anchor('settings', 'Settings', 'id="settings"'); ?></li>
						<li><?php echo anchor('user/sign_out', 'Sign Out', 'id="signout"'); ?></li>
					</ul>
				</li>
				<?php } else { ?>
				<li><?php echo anchor('user/sign_in', 'Sign In', 'id="signin"'); ?></li>
				<li><?php echo anchor('user/register', 'Register', 'id="register"'); ?></li>
				<?php } ?>
			</ul>

			<?php echo form_open('search', array('class' => 'navbar-form navbar-right', 'role' => 'search')); ?>
			<div class="form-group">
				<?php echo form_hidden('type', 'forums'); ?>
				<?php echo form_input(array('name' => 'q', 'type' => 'search', 'placeholder' => 'Search Forums', 'class' => 'form-control')); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</nav>

	<footer class="container">
		<p id="linkage">Fastfude is on <?php echo anchor('https://twitter.com/fastfude', '<i class="icon-twitter-sign"></i>&nbsp;Twitter', 'rel="publisher"'); ?>, <?php echo anchor('https://facebook.com/fastfude', '<i class="icon-facebook-sign"></i>&nbsp;Facebook', 'rel="publisher"'); ?> &amp; <?php echo anchor('https://github.com/junap/Fastfude', '<i class="icon-github-sign"></i>&nbsp;Github', 'rel="publisher"'); ?></p>
		<p id="blurb">Scenewrecking since 1997</p>
	</footer>

<script src="<?php echo base_url('assets/js/jquery-2.0.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
</body>
</html>
