<?php

include_once('main.php');

if(check_playground_login() != true) { exit; }

if(isset($_GET['venuejson']))
{
	$id = trim($_GET['id']);
	
	$venue = list_venue_by_id($id);
	
	if(!is_array($venue))
	{
	 echo '<span class="error_span">No results obtained please modify your search query</span>';
	 return;
	}
	
	echo json_encode($venue);
}
else if(isset($_GET['create_venue']))
{
	$venue_name = mysql_real_escape_string(trim($_POST['venue_name']));
	$venue_sports_type = mysql_real_escape_string($_POST['venue_sports_type']);
	$venue_time_slots = mysql_real_escape_string($_POST['venue_time_slots']);
	$rate_per_time_slot = mysql_real_escape_string($_POST['rate_per_time_slot']);
	$venue_location = mysql_real_escape_string($_POST['venue_location']);
	$venue_contact_number = mysql_real_escape_string($_POST['venue_contact_number']);
	$venue_day_off = mysql_real_escape_string($_POST['venue_day_off']); 
	
	echo create_or_update_venue($venue_name, $venue_sports_type, $venue_time_slots, $rate_per_time_slot, $venue_location, $venue_contact_number , $venue_day_off);
}
else if(isset($_GET['update_venue']))
{	
	$venue_id = trim($_POST['venue_id']);
	$venue_name = mysql_real_escape_string(trim($_POST['venue_name']));
	$venue_sports_type = mysql_real_escape_string($_POST['venue_sports_type']);
	$venue_time_slots = mysql_real_escape_string($_POST['venue_time_slots']);
	$rate_per_time_slot = mysql_real_escape_string($_POST['rate_per_time_slot']);
	$venue_location = mysql_real_escape_string($_POST['venue_location']);
	$venue_contact_number = mysql_real_escape_string($_POST['venue_contact_number']);
	echo create_or_update_venue($venue_name, $venue_sports_type, $venue_time_slots, $rate_per_time_slot, $venue_location, $venue_contact_number,$venue_id);
}
else if(isset($_GET['delete_venue_data']))
{
	$venue_id = trim($_POST['venue_id']);
	$data = $_POST['delete_data'];
	echo delete_venue_data($venue_id , $data);
}
else{
?>
<div class="box_div fat_centred_div" id=""><div class="box_top_div"><a href="#">Start</a> &gt; Your venues</div><div class="box_body_div">

<div id=""><?php echo list_venues(); ?></div>

<p class="center_p"><input type="button" class="small_button" id="update_venue_button" value="Update Venue">
<input type="button" class="small_button" id="delete_venue_button" value="Delete Venue"></p>
<p class="center_p" id="venue_administration_message_p"></p>
		
<hr/>
<h3><a href="" id="add_new_venue">Add New Venue</a></h3>
	<div id="new_venue_div"><div>

	<form action="." id="new_venue_form"><p>
	
	<div style="display:none">
	<input type="hidden"  id="venue_id_input" value=""><br><br>
	</div>
	<label for="venue_name_input">Venue name</label><br>
	<input type="text" id="venue_name_input"><br><br>
	<label for="venue_sports_type_input">Venue sports type</label><br>
	<input type="text" id="venue_sports_type_input"><br><br>
	<label for="venue_time_input">Venue time slots</label><br>
	<textarea id="venue_time_input"></textarea><br><br>
	<label for="venue_rate_input">Rate per time slot</label><br>
	<input type="text" id="venue_rate_input"><br><br>
	<label for="venue_location_input">Venue Location</label><br>
	<input type="text" id="venue_location_input"><br><br>
	<label for="venue_contact_number_input">Venue contact number</label><br>
	<input type="text" id="venue_contact_number_input"><br><br>
	<label for="venue_dayoff">Day off</label><br>
	<fieldset id="day_off">
		<input id="venue_dayoff" type="checkbox" name="day_off[]" value="1">Monday<br>
		<input id="venue_dayoff" type="checkbox" name="day_off[]" value="2">Tuesday<br>
		<input id="venue_dayoff" type="checkbox" name="day_off[]" value="3">Wednesday<br>
		<input id="venue_dayoff" type="checkbox" name="day_off[]" value="4">Thursday<br>
		<input id="venue_dayoff" type="checkbox" name="day_off[]" value="5">Friday<br>
		<input id="venue_dayoff" type="checkbox" name="day_off[]" value="6">Saturday<br>
		<input id="venue_dayoff" type="checkbox" name="day_off[]" value="7">Sunday<br>
	</fieldset>
	<br><br>
	<label for="about_input">Brief description:</label><br>
	<textarea id="about_input"></textarea><br><br>
	<label for="venue_agent_code_input">Agent code: <sup><a href="." id="user_secret_code_a" tabindex="-1">What's this?</a></sup></label><br>
	<input type="password" id="venue_agent_code_input"><br><br>
	<input type="submit" value="Save">

	</p></form>

	</div><div>
	
	<p class="blue_p bold_p">Information:</p>
	<ul>
	<li>Venue name is the court name , example : "Badminton court 1"</li>
	<li>Venue sports type example : badminton , tennis , cricket , football etc</li>
	<li>Enter all the time slots seperated by semicolon(;) , example:-<br/> 9AM-10AM;10AM-11AM;11AM-12PM;12PM-1PM;1PM-2PM <br/>or <br/> 10AM to 12PM;2PM to 4PM;6PM to 8PM <br/> etc</li>
	</ul>

	<div id="user_secret_code_div">Agent code is used to track an agent's referral while creating a new Venue. If you are unsure what to put, leave it blank.</div>
	
	</div></div>
	
	<p id="new_venue_message_p"></p>

<?php

}

?>