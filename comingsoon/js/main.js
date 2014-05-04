// Window load

$(window).load(function()
{	
	var images = new Array();
	images[0] = "img/3522242574_93e1c43174.jpg";
	images[1] = "img/Soccer_match_-_Rochester_vs_Carolina.JPG";
	images[2] = "img/Badminton_Semifinal_Pan_2007.jpg";
	
	var i = (Math.floor(Math.random()*10))%3;		
	$.backstretch([images[i]]);

});
