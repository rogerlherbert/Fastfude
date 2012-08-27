<?php
	if ($this->session->userdata('user_id')) {
		echo "logged in as ". $this->session->userdata('user_id'). anchor('user/sign_out', "sign out now");
	} else {
		echo "not logged in. ". anchor('user/sign_in', "sign in now") ." or ". anchor('user/register', "register a new user");
	}
?>

</body>
</html>