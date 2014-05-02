<?php
include_once('_includes.php');

//Get attribute functions

function get_venue_attribute($attribute , $venue_id)
{
	$query_statement = "SELECT $attribute from " .global_mysql_venues_table. " WHERE id = $venue_id";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	
	if(mysql_num_rows($result) < 1)
	{
		return('<span class="error_span">No results obtained please modify your search query</span>');
	}
	
	$venue = mysql_fetch_array($result);
	
	return $venue[$attribute];
}

function get_playground_attribute($attribute , $venue_id)
{
	$query_statement = "SELECT $attribute from " .global_mysql_playgrounds_table. " WHERE id = $venue_id";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	
	if(mysql_num_rows($result) < 1)
	{
		return('<span class="error_span">No results obtained please modify your search query</span>');
	}
	
	$venue = mysql_fetch_array($result);
	
	return $venue[$attribute];
}



// Playground functions

function playground_email_exists($playground_email)
{
	$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . " WHERE playground_email='$playground_email'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) > 0)
	{
		return(true);
	}
}

function get_playground_login_data($data)
{
	if($data == 'playground_email' && isset($_COOKIE[global_cookie_prefix . '_playground_email']))
	{
		return($_COOKIE[global_cookie_prefix . '_playground_email']);
	}
	elseif($data == 'playground_password' && isset($_COOKIE[global_cookie_prefix . '_playground_password']))
	{
		return($_COOKIE[global_cookie_prefix . '_playground_password']);
	}
}

function playgroundlogin($playground_email, $playground_password, $playground_remember)
{
	logout();
	
	$playground_password_encrypted = encrypt_password($playground_password);
	$playground_password = add_salt($playground_password);
	
	$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . " WHERE playground_email='$playground_email' AND playground_password='$playground_password_encrypted' OR playground_email='$playground_email' AND playground_password='$playground_password'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) == 1)
	{
			$playground = mysql_fetch_array($query);

			$_SESSION['user_id'] = $playground['playground_id'];
			$_SESSION['user_is_admin'] = 1;
			$_SESSION['user_email'] = $playground['playground_email'];
			$_SESSION['user_name'] = $playground['playground_name'];
			$_SESSION['user_reservation_reminder'] = $playground['playground_reservation_reminder'];
			$_SESSION['logged_in'] = '1';
			$_SESSION['logged_in_as_playground'] = '1';
			
			if($playground_remember == '1')
			{
				$playground_password = strip_salt($playground['playground_password']);

				setcookie(global_cookie_prefix . '_playground_email', $playground['playground_email'], time() + 3600 * 24 * intval(global_remember_login_days));
				setcookie(global_cookie_prefix . '_playground_password', $playground_password, time() + 3600 * 24 * intval(global_remember_login_days));
			}

			return(1);
	}
}

function check_playground_login()
{
	if( !isset($_SESSION['logged_in_as_playground']) )
	{
		return false;
	}
	$playground_id = $_SESSION['user_id'];
	$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . " WHERE playground_id='$playground_id'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) == 1)
	{
		return(true);
	}
	else
	{
		logout();
		echo '<script type="text/javascript">window.location.replace(\'.\');</script>';
	}
}

function create_playground($playground_name, $playground_email, $playground_password, $locality , $address, $playground_secret_code)
{
	/*if(validate_user_name($playground_name) != true)
	{
		return('<span class="error_span">Name must be <u>letters only</u> and be <u>2 to 12 letters long</u>. If your name is longer, use a short version of your name</span>');
	}*/
	if(validate_email($playground_email) != true)
	{
		return('<span class="error_span">Email must be a valid email address and be no more than 50 characters long</span>');
	}
	elseif(validate_user_password($playground_password) != true)
	{
		return('<span class="error_span">Password must be at least 4 characters</span>');
	}
	elseif(global_secret_code != '0' && $playground_secret_code != global_secret_code)
	{
		return('<span class="error_span">Wrong secret code</span>');
	}
	elseif(playground_email_exists($playground_email) == true)
	{
		return('<span class="error_span">Email is already registered. <a href="#forgot_password">Forgot your password?</a></span>');
	}
	else
	{
		$query = mysql_query("SELECT * FROM " . global_mysql_playgrounds_table . "")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		if(mysql_num_rows($query) == 0)
		{
			$playground_is_admin = '1';
		}
		else
		{
			$playground_is_admin = '0';
		}

		$playground_password = encrypt_password($playground_password);

		mysql_query("INSERT INTO " . global_mysql_playgrounds_table . " (playground_is_admin,playground_email,playground_password,playground_name,playground_location,locality,playground_reservation_reminder) VALUES ($playground_is_admin,'$playground_email','$playground_password','$playground_name','$locality', '$address' ,'0')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		$playground_password = strip_salt($playground_password);

		setcookie(global_cookie_prefix . '_playground_email', $playground_email, time() + 3600 * 24 * intval(global_remember_login_days));
		setcookie(global_cookie_prefix . '_playground_password', $playground_password, time() + 3600 * 24 * intval(global_remember_login_days));

		return(1);
	}
}

function list_playground_by_id ($id)
{
	//return playground info
	$query_statement = "SELECT * from " .global_mysql_playgrounds_table. " WHERE playground_id = $id";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	
	if(mysql_num_rows($result) < 1)
	{
		return('<span class="error_span">No results obtained please modify your search query</span>');
	}
	
	$venue = mysql_fetch_array($result);
	
	return $venue;
}

//Venue functions

function create_or_update_venue($venue_name, $venue_sports_type, $venue_time_slots, $rate_per_time_slot, $venue_location, $venue_contact_number,$venue_day_off, $venue_id='')
{
	$playground_id = $_SESSION['user_id'];
	
	if($venue_id == '')
	{
	mysql_query("INSERT INTO " . global_mysql_venues_table . " (name,sports_type,time_slots,rate,location,contact_number,day_off,playground_id ) VALUES ('$venue_name', '$venue_sports_type', '$venue_time_slots', '$rate_per_time_slot', '$venue_location', '$venue_contact_number','$venue_day_off', '$playground_id')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	}
	else
	{
	//Update
	}
	return 1;
}

function delete_venue_data($venue_id , $data)
{
	$playground_id = $_SESSION['user_id'];
	
	//Check if venue , belongs to logged in playground
	$query = mysql_query("SELECT * FROM " . global_mysql_venues_table . " WHERE id = $venue_id AND playground_id = $playground_id")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) < 1)
	{
		return('<span class="error_span">You have not added any venues. Add one below.</span>');
	}

	mysql_query("DELETE from " . global_mysql_venues_table . " WHERE id = $venue_id")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	return(1);
}

function list_venues($playground_id = '')
{
	if($playground_id == '')
	{
		$playground_id = $_SESSION['user_id'];
	}

$query = mysql_query("SELECT * FROM " . global_mysql_venues_table . " WHERE playground_id = $playground_id")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($query) < 1)
	{
		return('<span class="error_span">You have not added any venues. Add one below.</span>');
	}
	
	$venues = '<table id="venues_table"><tr><th>Venue Name</th><th>Venue sports type</th><th>Venue time slots</th><th>Rate</th><th>Venue Location</th><th>Contact Number</th><th></th></tr>';

	while($venue = mysql_fetch_array($query))
	{
		$venues .= '<tr id="venue_tr_' . $venue['id'] .'"><td>';
		$venues .= '<label for="venue_radio_' . $venue['name'] . '">' . $venue['name'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['sports_type'] . '">' . $venue['sports_type'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['time_slots'] . '">' . $venue['time_slots'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['rate'] . '">' . $venue['rate'] . '</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['location'] . '">' . $venue['location'] .'</label></td><td>';
		$venues .= '<label for="venue_radio_' . $venue['contact_number'] . '">' . $venue['contact_number'] .'</label></td><td>';
		$venues .= '<input type="radio" name="venue_radio" class="venue_radio" id="venue_radio_' . $venue['id'] . '" value="' . $venue['id'] . '">';
		$venues .= '</td></tr>';
	}

	$venues .= '</table>';

	return($venues);
}

function list_playgrounds_and_venues_by_name($name)
{
	$query_statement = "SELECT * from ".global_mysql_playgrounds_table . " WHERE playground_name LIKE '%$name%'";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	
	if(mysql_num_rows($result) < 1)
	{
		return('<span class="error_span">No results obtained please modify your search query</span>');
	}
	
	while($playground = mysql_fetch_array($result))
	{
		echo $playground['playground_name'];
		echo list_venues($playground['playground_id']);
	}

}

function list_venues_by_sports_location( $sports_type , $location)
{
	if($location == '' )
	{
		return('<span class="error_span">Please enter a location to search</span>');
	}
	
	$query_statement = "SELECT *  FROM " . global_mysql_playgrounds_table . " as playground ," . global_mysql_venues_table . " as venue ";
	$query_statement .= " WHERE venue.`sports_type` LIKE '%$sports_type%' AND playground.`locality` LIKE '%$location%' AND venue.playground_id = playground.playground_id";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

	if(mysql_num_rows($result) < 1)
	{
		return 0;
	}
	
	$venues = array();
	
	while($venue = mysql_fetch_array($result))
	{
		array_push( $venues , $venue );
	}
	
	return($venues);
}

function list_venue_by_id($id)
{
	//$query_statement = "SELECT * from " .global_mysql_venues_table. " WHERE id = $id";
	$query_statement = "SELECT playground_name,name,sports_type,time_slots,day_off,rate,locality,playground_location,location,contact_number from ". global_mysql_venues_table." as venues,".global_mysql_playgrounds_table. " as playgrounds where id =$id and playgrounds.playground_id = venues.playground_id";
	
	$result = mysql_query($query_statement)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	
	if(mysql_num_rows($result) < 1)
	{
		return('<span class="error_span">No results obtained please modify your search query</span>');
	}
	
	$venue = mysql_fetch_array($result);
	
	return $venue;
}


// Reservations

function highlight_day($day)
{
	$day = str_ireplace(global_day_name, '<span id="today_span">' . global_day_name . '</span>', $day);
	return $day;
}


function read_reservation($venue_id, $week, $day, $time)
{
	$day_off = get_venue_attribute('day_off', $venue_id);
	
	//Check day offs
	$pos = strpos($day_off,(string)$day);
			
	if($pos === false)
	{
	//If booking allowed for that day
		$query = mysql_query("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_venue_id='$venue_id'  AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
		$reservation = mysql_fetch_array($query);
		if(!empty($reservation))
		{
			//return($reservation['reservation_user_name']);
			return("Booked");
		}
		else
		{
			return "";
		}
	}
	
	//If booking not allowed for that day
	return ("No Booking");
}

function read_reservation_details($venue_id, $week, $day, $time)
{
	//Allow this only for the owner of the venue
	if( !isset($_SESSION['logged_in_as_playground']) )
	{
		return 0;
	}
	$playground_id = $_SESSION['user_id'];
	if($playground_id  != get_venue_attribute('playground_id', $venue_id))
	{
		return 0;
	}
	
	$query = mysql_query("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_venue_id='$venue_id'  AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
	$reservation = mysql_fetch_array($query);

	if(empty($reservation))
	{
		return(0);	
	}
	else
	{
		return('<b>Reservation made:</b> ' . $reservation['reservation_made_time'] . '<br><b>User\'s email:</b> ' . $reservation['reservation_user_email']);
	}
}

function make_reservation($venue_id, $week, $day, $time)
{
	$user_id = $_SESSION['user_id'];
	$user_email = $_SESSION['user_email'];
	$user_name = $_SESSION['user_name'];
	
	//Check if day is allowed at venue
	
	//get day off
	$day_off = get_venue_attribute('day_off', $venue_id);
	//Check day offs
	$pos = strpos($day_off,(string)$day);
	if($pos !== false)
	{
		return('This day is not available at the venue');
	}
	
	//Check if time it is allowed at the venue
	
	//get time slots
	$time_slots = get_venue_attribute('time_slots',$venue_id);
	//check time slot
	$pos = strpos($time_slots, $time);
	if($pos === false)
	{
		return('This time slot is not available at the venue');
	}
	
	//Get price from the venue details
	$price = get_venue_attribute('rate',$venue_id);
	
	if($week == '0' && $day == '0' && $time == '0')
	{
		//Currently not allowing this
		return('You can\'t register a booking like this');
		/*
		mysql_query("INSERT INTO " . global_mysql_reservations_table . " (reservation_venue_id,reservation_made_time,reservation_week,reservation_day,reservation_time,reservation_price,reservation_user_id,reservation_user_email,reservation_user_name) VALUES ('$venue_id',now(),'$week','$day','$time','$price','$user_id','$user_email','$user_name')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		return(1);
		*/
	}
	elseif($week < global_week_number && $_SESSION['user_is_admin'] != '1' || $week == global_week_number && $day < global_day_number && $_SESSION['user_is_admin'] != '1')
	{
		return('You can\'t reserve back in time');
	}
	elseif($week > global_week_number + global_weeks_forward && $_SESSION['user_is_admin'] != '1')
	{
		return('You can only reserve ' . global_weeks_forward . ' weeks forward in time');
	}
	else
	{
		$query = mysql_query("SELECT * FROM " . global_mysql_reservations_table . " WHERE reservation_venue_id = '$venue_id' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

		if(mysql_num_rows($query) < 1)
		{
			$year = global_year;

			mysql_query("INSERT INTO " . global_mysql_reservations_table . " (reservation_venue_id,reservation_made_time,reservation_year,reservation_week,reservation_day,reservation_time,reservation_price,reservation_user_id,reservation_user_email,reservation_user_name) VALUES ('$venue_id',now(),'$year','$week','$day','$time','$price','$user_id','$user_email','$user_name')")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

			return(1);
		}
		else
		{
			return('Someone else just reserved this time');
		}
	}
}

function delete_reservation($venue_id, $week, $day, $time)
{
	if($week < global_week_number && $_SESSION['user_is_admin'] != '1' || $week == global_week_number && $day < global_day_number && $_SESSION['user_is_admin'] != '1')
	{
		return('You can\'t reserve back in time');
	}
	elseif($week > global_week_number + global_weeks_forward && $_SESSION['user_is_admin'] != '1')
	{
		return('You can only reserve ' . global_weeks_forward . ' weeks forward in time');
	}
	else
	{
		$query = mysql_query("SELECT * FROM " . global_mysql_reservations_table . " WHERE  reservation_venue_id = '$venue_id' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
		$user = mysql_fetch_array($query);

		if($user['reservation_user_id'] == $_SESSION['user_id'] || $_SESSION['user_is_admin'] == '1')
		{
			mysql_query("DELETE FROM " . global_mysql_reservations_table . " WHERE  reservation_venue_id = '$venue_id' AND reservation_week='$week' AND reservation_day='$day' AND reservation_time='$time'")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

			return(1);
		}
		else
		{
			return('You can\'t remove other users\' reservations');
		}
	}
}

?>