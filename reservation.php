<?php

include_once('main.php');

//if(check_login() != true) { exit; }

if(isset($_GET['make_reservation']))
{
	$venue_id = mysql_real_escape_string($_POST['venue_id']);
	$week = mysql_real_escape_string($_POST['week']);
	$day = mysql_real_escape_string($_POST['day']);
	$time = mysql_real_escape_string($_POST['time']);
	echo make_reservation($venue_id, $week, $day, $time);
}
elseif(isset($_GET['delete_reservation']))
{
	$venue_id = mysql_real_escape_string($_POST['venue_id']);
	$week = mysql_real_escape_string($_POST['week']);
	$day = mysql_real_escape_string($_POST['day']);
	$time = mysql_real_escape_string($_POST['time']);
	echo delete_reservation($venue_id, $week, $day, $time);
}
elseif(isset($_GET['read_reservation']))
{
	$venue_id = mysql_real_escape_string($_POST['venue_id']);
	$week = mysql_real_escape_string($_POST['week']);
	$day = mysql_real_escape_string($_POST['day']);
	$time = mysql_real_escape_string($_POST['time']);
	echo read_reservation($venue_id,$week, $day, $time);
}
elseif(isset($_GET['read_reservation_details']))
{
	$venue_id = mysql_real_escape_string($_POST['venue_id']);
	$week = mysql_real_escape_string($_POST['week']);
	$day = mysql_real_escape_string($_POST['day']);
	$time = mysql_real_escape_string($_POST['time']);
	echo read_reservation_details($venue_id, $week, $day, $time);
}
elseif(isset($_GET['week']))
{
	$week = mysql_real_escape_string($_GET['week']);
	$venue_id = mysql_real_escape_string($_GET['venue_id']);
	
	$venue_times = explode(';', $_SESSION['venue']['Venue_time_slots']);
	
	echo '<table id="reservation_table"><colgroup span="1" id="reservation_time_colgroup"></colgroup><colgroup span="7" id="reservation_day_colgroup"></colgroup>';

	//display date along with the day
	$week_start = new DateTime();
	
	$days_row = '<tr><td id="reservation_corner_td"><input type="button" class="blue_button small_button" id="reservation_today_button" value="Today"></td>';
	$days_row.= '<th class="reservation_day_th">Monday<br/>';
	$week_start->setISODate(global_year,$week,1);
	$days_row.= $week_start->format('d-M-Y').'</th>';
	$days_row.='<th class="reservation_day_th">Tuesday<br/>';
	$week_start->setISODate(global_year,$week,2);
	$days_row.= $week_start->format('d-M-Y').'</th>';
	$days_row.='<th class="reservation_day_th">Wednesday<br/>';
	$week_start->setISODate(global_year,$week,3);
	$days_row.= $week_start->format('d-M-Y').'</th>';
	$days_row.='<th class="reservation_day_th">Thursday<br/>';
	$week_start->setISODate(global_year,$week,4);
	$days_row.= $week_start->format('d-M-Y').'</th>';
	$days_row.='<th class="reservation_day_th">Friday<br/>';
	$week_start->setISODate(global_year,$week,5);
	$days_row.= $week_start->format('d-M-Y').'</th>';
	$days_row.='<th class="reservation_day_th">Saturday<br/>';
	$week_start->setISODate(global_year,$week,6);
	$days_row.= $week_start->format('d-M-Y').'</th>';
	$days_row.='<th class="reservation_day_th">Sunday<br/>';
	$week_start->setISODate(global_year,$week,7);
	$days_row.= $week_start->format('d-M-Y').'</th></tr>';

	
	if($week == global_week_number)
	{
		echo highlight_day($days_row);
	}
	else
	{
		echo $days_row;
	}
	
	$chart = prepare_reservation_chart_week($week);
	
	foreach($venue_times as $time)
	{
		echo '<tr><th class="reservation_time_th">' . $time . '</th>';

		$i = 0; // day_number

		while($i < 7)
		{
			$i++;
			
			echo '<td><div class="reservation_time_div"><div class="reservation_time_cell_div" id="div:' . $week . ':' . $i . ':' . $time . ':' .$venue_id .'" onclick="void(0)">' . $chart[$time][$i] . '</div></div></td>';
		}

		echo '</tr>';
	}

	echo '</table>';
}
else
{
	echo '</div><div class="box_div" id="reservation_div"><div class="box_top_div" id="reservation_top_div"><div id="reservation_top_left_div"><a href="." id="previous_week_a">&lt; Previous week</a></div><div id="reservation_top_center_div">Reservations for week <span id="week_number_span">' . global_week_number . '</span></div><div id="reservation_top_right_div"><a href="." id="next_week_a">Next week &gt;</a></div></div><div class="box_body_div"><div id="reservation_table_div"></div></div></div><div id="reservation_details_div">';
}

?>
