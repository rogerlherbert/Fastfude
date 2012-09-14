</div>

<nav>
	<?php echo anchor('/', img('assets/img/logo.gif'), 'id="logo" title="Fastfude"'); ?>
	<div id="login"><?php
		if ($this->session->userdata('user_id')) {
			echo "logged in as ". anchor('user/id/'.$this->session->userdata('user_id'), $this->session->userdata('user_id')) . " " . anchor('user/sign_out', "sign out now");
		} else {
			echo "not logged in. ". anchor('user/sign_in', "sign in now") ." or ". anchor('user/register', "register a new user");
		}
	?></div>
</nav>

<footer>
	<p id="indie_bastards">Independent Music in Ireland <?php echo anchor('http://www.thumped.com/', 'Thumped'); ?> | <?php echo anchor('http://www.metalireland.com/', 'Metal Ireland'); ?> | <?php echo anchor('/', 'Fastfude'); ?></p>
	<p id="blurb">Fastfude &copy; 1997 - <?php echo date('Y'); ?> Roger Herbert. <?php echo anchor('https://github.com/junap/Fastfude', 'Help make Fastfude better'); ?>.</p>
</footer>

</body>
</html>
