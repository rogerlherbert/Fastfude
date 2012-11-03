</div>

<nav>
	<?php echo anchor('user/sign_in', '<span>User</span>', ' id="user" class="icon-user nav-button"'); ?>

	<div id="login"><?php
		if ($this->session->userdata('user_id')) {
			echo anchor('user/id/'.$this->session->userdata('user_id'), img($this->session->userdata('gravatar_id')));
			echo anchor('user/id/'.$this->session->userdata('user_id'), $this->session->userdata('username'));
			echo anchor('user/sign_out', "sign out");
		} else {
			echo anchor('user/sign_in', img('assets/img/unknown_user.png'));
			echo anchor('user/sign_in', "sign in") . ' | ';
			echo anchor('user/register', "register");
		}
	?></div>

	<?php echo anchor('/', '<span>Home</span>', 'id="home" title="Home" class="icon-home nav-button" rel="home"'); ?>

	<div id="sections">
		<?php echo anchor('gigs', '<span>Gigs</span>', 'id="nav_gigs" class="icon-music nav-button" title="Gigs"'); ?>
		<?php echo anchor('wiki', '<span>Wiki</span>', 'id="nav_wiki" class="icon-book nav-button" title="Wiki"'); ?>
		<?php echo anchor('messages', '<span>Messages</span>', 'id="nav_messages" class="icon-envelope-alt nav-button" title="Messages"'); ?>
	</div>
</nav>

<?php echo form_open('search', array('id' => 'search')); ?>
<?php echo form_hidden('type', 'forums'); ?>
<?php echo form_input(array('name' => 'q', 'type' => 'search', 'placeholder' => 'Search Forums')); ?>
<?php echo form_close(); ?>

<footer>
	<p id="linkage">Fastfude is on <?php echo anchor('https://twitter.com/fastfude', 'Twitter', ' class="icon-twitter-sign" rel="publisher"'); ?>, <?php echo anchor('https://facebook.com/fastfude', 'Facebook', ' class="icon-facebook-sign" rel="publisher"'); ?> &amp; <?php echo anchor('https://github.com/junap/Fastfude', 'Github', ' class="icon-github-sign" rel="publisher"'); ?></p>
	<p id="blurb">Scenewrecking since 1997</p>
</footer>

</body>
</html>
