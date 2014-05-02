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


<div class="box_div centred_div" id="">
<div class="box_top_div">View Your Bookings</div>
<div class="box_body_div">
<form action="." id=""><p>

<table>
<tr>
	<td>Mobile Number:</td>
	<td></td>
	<td>Email:</td>
</tr>
<tr>
	<td><input type="text" id="game_type_input"  placeholder=""></td>
	<td>Or</td>
	<td><input type="text" id="location_input"  placeholder="" autocapitalize="off"></td>
	<td><input type="submit" value="Get Bookings"></td>
</tr>
</table>

</form>	

<div id="preload_div">
<img src="img/loading.gif" alt="Loading">
</div>

</body>

</html>
