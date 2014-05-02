<?php

include_once('main.php');

//If logged in as user , don't allow
if(check_user_login() == true) { exit; }

if(isset($_GET['login']))
{
	$playground_email = mysql_real_escape_string($_POST['playground_email']);
	$playground_password = mysql_real_escape_string($_POST['playground_password']);
	$playground_remember = $_POST['playground_remember'];
	echo playgroundlogin($playground_email, $playground_password, $playground_remember);
}
elseif(isset($_GET['logout']))
{
	logout();
}
elseif(isset($_GET['create_playground']))
{
	$playground_name = mysql_real_escape_string(trim($_POST['playground_name']));
	$playground_email = mysql_real_escape_string($_POST['playground_email']);
	$playground_password = mysql_real_escape_string($_POST['playground_password']);
	$locality_input = mysql_real_escape_string($_POST['locality_input']);
	$address_input = mysql_real_escape_string($_POST['address_input']);
	$playground_secret_code = $_POST['playground_secret_code'];
	echo create_playground($playground_name, $playground_email, $playground_password, $locality_input,$address_input, $playground_secret_code);
}
elseif(isset($_GET['new_playground']))
{

?>

	<div class="box_div" id="login_div"><div class="box_top_div"><a href="#">Start</a> &gt; New Playground</div><div class="box_body_div">
	<div id="new_user_div"><div>

	<form action="." id="new_playground_form"><p>

	<label for="playground_name_input">Playground Name:</label><br>
	<input type="text" id="playground_name_input"><br><br>
	<label for="locality_input">Locality:</label><br>
	<input type="text" id="locality_input"><br><br>
	<label for="address_input">Playground Address:</label><br>
	<textarea id="address_input"></textarea><br><br>
	<label for="about_input">Brief description:</label><br>
	<textarea id="about_input"></textarea><br><br>
	<label for="playground_email_input">Email:</label><br>
	<input type="text" id="playground_email_input" autocapitalize="off"><br><br>
	<label for="playground_password_input">Password:</label><br>
	<input type="password" id="playground_password_input"><br><br>
	<label for="playground_password_confirm_input">Confirm password:</label><br>
	<input type="password" id="playground_password_confirm_input"><br><br>

<?php

	if(global_secret_code != '0')
	{
		echo '<label for="playground_secret_code_input">Secret code: <sup><a href="." id="user_secret_code_a" tabindex="-1">What\'s this?</a></sup></label><br><input type="password" id="playground_secret_code_input"><br><br>';
	}

?>

	<input type="submit" value="Create New Playground">

	</p></form>

	</div><div>
	
	<p class="blue_p bold_p">Information:</p>
	<ul>
	<li>You can manage reservations at your playground</li>
	<li>Your usage is stored automatically</li>
	<li>Your password is encrypted and can't be read</li>
	</ul>

	<div id="user_secret_code_div">Secret code is used to only allow certain people to create a new playground. Contact the webmaster by email at <span id="email_span"></span> to get the secret code.</div>

	<script type="text/javascript">$('#email_span').html('<a href="mailto:'+$.base64.decode('<?php echo base64_encode(global_webmaster_email); ?>')+'">'+$.base64.decode('<?php echo base64_encode(global_webmaster_email); ?>')+'</a>');</script>

	</div></div>

	<p id="new_playground_message_p"></p>

	</div></div>

<?php

}
elseif(isset($_GET['forgot_password']))
{

?>

	<div class="box_div" id="login_div"><div class="box_top_div"><a href="#">Start</a> &gt; Forgot password</div><div class="box_body_div">

	<p>Contact one of the admins below by email and write that you've forgotten your password, and you will get a new one. The password can be changed after logging in.</p>

	<?php echo list_admin_playgrounds(); ?>

	</div></div>

<?php

}
else
{

?>

	<div class="box_div" id="login_div"><div class="box_top_div">Playground log in</div><div class="box_body_div">

	<form action="." id="playground_login_form" autocomplete="off"><p>

	<label for="playground_email_input">Email:</label><br><input type="text" id="playground_email_input" value="<?php echo get_playground_login_data('playground_email'); ?>" autocapitalize="off"><br><br>
	<label for="playground_password_input">Password:</label><br><input type="password" id="playground_password_input" value="<?php echo get_playground_login_data('playground_password'); ?>"><br><br>
	<input type="checkbox" id="remember_me_checkbox" checked="checked"> <label for="remember_me_checkbox">Remember me</label><br><br>		
	<input type="submit" value="Log in">

	</p></form>

	<p id="login_message_p"></p>
	<p><a href="#new_playground">New Playground</a> | <a href="#forgot_password">Forgot password</a></p>

	</div></div>

<?php

}

?>
