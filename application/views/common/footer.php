		</div>
	</div>

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php echo anchor('/', 'Fastfude', 'class="navbar-brand" rel="home"'); ?>
		</div>

		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav">
				<li><?php echo anchor('topics', 'Topics'); ?></li>
				<li><?php echo anchor('gigs', 'Gigs'); ?></li>
				<li><?php echo anchor('wiki', 'Wiki'); ?></li>
				<li><?php echo anchor('messages', 'Messages'); ?></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<?php if ($this->session->userdata('user_id')) { ?>
				<li class="dropdown">
					<?php echo anchor('user/id/'.$this->session->userdata('user_id'), $this->session->userdata('username') . ' <b class="caret"></b>', 'class="dropdown-toggle" data-toggle="dropdown"'); ?>
					<ul class="dropdown-menu">
						<li><?php echo anchor('settings', 'Settings'); ?></li>
						<li><?php echo anchor('user/sign_out', 'Sign Out'); ?></li>
					</ul>
				</li>
				<?php } else { ?>
				<li><?php echo anchor('user/sign_in', 'Sign In'); ?></li>
				<li><?php echo anchor('user/register', 'Register'); ?></li>
				<?php } ?>
			</ul>

			<?php echo form_open('search', array('class' => 'navbar-form navbar-right', 'role' => 'search')); ?>
			<div class="form-group">
				<?php echo form_hidden('type', 'topics'); ?>
				<?php echo form_input(array('name' => 'q', 'type' => 'search', 'placeholder' => 'Search Topics', 'class' => 'form-control')); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</nav>

	<footer class="container">
		<p id="linkage">Fastfude is on <?php echo anchor('https://twitter.com/fastfude', '<i class="fa fa-twitter"></i>&nbsp;Twitter', 'rel="publisher"'); ?>, <?php echo anchor('https://facebook.com/fastfude', '<i class="fa fa-facebook"></i>&nbsp;Facebook', 'rel="publisher"'); ?> &amp; <?php echo anchor('https://github.com/junap/Fastfude', '<i class="fa fa-github"></i>&nbsp;Github', 'rel="publisher"'); ?></p>
		<p id="blurb">Scenewrecking since 1997</p>
	</footer>

<script src="<?php echo base_url('assets/js/jquery-2.0.3.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
</body>
</html>
