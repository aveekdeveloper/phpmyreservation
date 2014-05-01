<?php include_once('main.php'); ?>

<!DOCTYPE html>

<html>

<head>

<meta http-equiv="content-type" content="text/html;charset=utf-8">

<noscript><meta http-equiv="refresh" content="0; url=error.php?error_code=2"></noscript>

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-cookies.js" type="text/javascript"></script>
<script src="js/jquery-base64.js" type="text/javascript"></script>
<?php include('js/header-js.php'); ?>
<script src="js/main.js" type="text/javascript"></script>
<script src="js/backstretch.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js" ></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js"></script>

<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="img/favicon.ico">

<title><?php echo global_title . ' - ' . global_organization; ?></title>

</head>

<body>

<div id="notification_div"><div id="notification_inner_div"><div id="notification_inner_cell_div"></div></div></div>

<div id="header_div"><?php include('header.php'); ?></div>

<h1><?php //echo global_title; ?></h1>
<h2><?php //echo global_organization; ?></h2>

<div id="content_div"></div>

<div id="booking_div">
	<div class="booking_div_header">
		<h3>Your Unpaid Bookings</h3>
	</div>
	<div id="booking_div_body">
	</div>
	<hr/>
	<div id="booking_div_total" class="pull_right">
	</div>
	<hr/>
	<div id="booking_info" class="center">
	<h3>Enter your details below :</h3>
	<form >
		<label for="booking_name_input">Name:</label>
		<input id="booking_name_input" type="text" value="">
		<label for="booking_phone_input">Mobile number:</label>
		<input id="booking_phone_input" type="text">
		<label for="booking_email_input">Email:</label>
		<input id="booking_email_input" type="text" value="<?php echo get_login_data('user_email'); ?>">
	</form>
	</div>
	<hr/>
	<div id="booking_div_submit_button" class="pull_right">
	<input type="submit" id="clear_booking_button" value="Clear bookings">
	<input type="submit" value="Proceed to Pay">
	</div>
</div>

<div id="preload_div">
<img src="img/loading.gif" alt="Loading">
</div>

</body>

</html>
