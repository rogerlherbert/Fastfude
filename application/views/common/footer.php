</div>

<nav>
	<?php echo anchor('/', img('assets/img/logo.gif'), 'id="logo" title="Fastfude"'); ?>

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

	<div id="sections">
		<?php echo anchor('forums', 'Forums', 'id="nav_forums"'); ?>
		<?php echo anchor('gigs', 'Gigs', 'id="nav_gigs"'); ?>
		<?php echo anchor('wiki', 'Wiki', 'id="nav_wiki"'); ?>
		<?php echo anchor('messages', 'Messages', 'id="nav_messages"'); ?>
	</div>
</nav>

<footer>
	<p id="indie_bastards">Independent Music in Ireland <?php echo anchor('http://www.thumped.com/', 'Thumped'); ?> | <?php echo anchor('http://www.metalireland.com/', 'Metal Ireland'); ?> | <?php echo anchor('/', 'Fastfude'); ?></p>
	<p id="blurb">Fastfude &copy; 1997 - <?php echo date('Y'); ?> Roger Herbert. <?php echo anchor('https://github.com/junap/Fastfude', 'Help make Fastfude better'); ?>.</p>
</footer>

</body>
</html>
