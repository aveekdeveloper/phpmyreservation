<?php include_once('main.php'); ?>

<div id="header_inner_div"><div id="header_inner_left_div">

<a href=".">Home</a> | <a href="#bookings">Booking Information</a>

</div><div id="header_inner_center_div">
<?php 

if(isset($_SESSION['user_name']))
{
	echo 'Welcome, '.$_SESSION['user_name'];
}

?>
</div><div id="header_inner_right_div">

<?php

if(isset($_SESSION['logged_in']))
{	
	if(isset($_SESSION['logged_in_as_playground']))
	{
		echo '<a href="#dashboard">Dashboard</a>';
	}
	else
	{
		echo '<a href="#cp">Control panel</a>';
	}
	
	echo ' | <a href="#logout">Logout</a>';
}
else
{
	//echo 'Not logged in';
	echo '<a href="#userlogin">User Login</a> | <a href="#playgroundlogin">Playground Login</a>';
}

?>

</div></div>
