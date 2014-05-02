<?php
include_once('main.php');

if(isset($_GET['search_venue']))
{
	$venue = mysql_real_escape_string(trim($_GET['venue_name']));
	
	echo list_playgrounds_and_venues_by_name($venue);
} 
else if(isset($_GET['search']))
{
	$sports_type = isset($_GET['sports_type']) ? mysql_real_escape_string(trim($_GET['sports_type'])) : '';
	$location = isset($_GET['location']) ? mysql_real_escape_string(trim($_GET['location'])) : '';
	
	$venues = list_venues_by_sports_location($sports_type , $location);
	
	if($venues == 0)
	{
		echo(
			'<div class="box_div centred_div">
				<div class="search_box_body_div ">
				<span class="error_span">No results obtained please modify your search query</span>
				</div>	
			</div>'
			);
			
		return;
	}
	
	foreach ($venues as $venue) 
	{ //start for each
?>
<div class="flat_box_div centred_div">
	<div class="flat_box_body_div ">
		<h3><a href="<?php echo "?venue=$venue[Venue_id]" ?>"><?php echo $venue['Venue_playground_name']. "," .$venue['Venue_name'] ?></a></h3>
		<span class="soft"><?php echo $venue['Venue_sports_type']; ?></span>
		<br/>
		<?php echo $venue['Venue_playground_locality']; ?> > <span class="soft"><?php echo $venue['Venue_playground_address'] ?></span>
		<br/>
		<span class="soft">Time slots : <?php echo $venue['Venue_time_slots'] ?></span>
		<br/>
		<span class="soft">Rate : </span><?php echo $venue['Venue_rate_per_time_slot'] ?> per slot
		<span class="soft">Contact : <?php echo $venue['Venue_contact_number'] ?></span>
		<br/>
		<a href="">Reviews</a> | <a href="">Reservations</a>
	</div>	
</div>
<?php
	}//end for each
}
else
{
?>

<h1 class="search blue" >Which game are you going to play?</h1>
<h2 class="search blue" >Search a play area near you</h2>

<div class="box_div centred_div" id="search_div">
<div class="search_box_body_div">
<form action="." id="game_search_form"><p>

<table>
<tr>
	<td>Game type, ex: badminton</td>
	<td>Location:</td>
</tr>
<tr>
	<td><input type="text" id="game_type_input" class="large_text" placeholder="Game type, ex: badminton"></td>
	<td><input type="text" id="location_input" class="large_text" placeholder="Location" autocapitalize="off"></td>
	<td><input type="submit" value="Search"></td>
</tr>
</table>

</form>	
</div>
</div>

<div id="search_results"></div>

<?php

}
?>