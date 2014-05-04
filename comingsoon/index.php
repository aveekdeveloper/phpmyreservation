<?php //include_once('main.php'); ?>

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

<title><?php //echo global_title . ' - ' . global_organization; ?></title>

</head>

<body>

<div id="notification_div"><div id="notification_inner_div"><div id="notification_inner_cell_div"></div></div></div>

<div id="header_div"><?php include('header.php'); ?></div>

<div>
<h1 class="search" >BookMeAgame.com</h1>
<h2 class="search" >Discover a playground near you!</h2>
<br/>
<h2 class="search" >Coming soon in Bangalore!</h2>
<br/>
<br/>
<br/>
<br/>
<div class="box_div centred_div" style="width:400px;">
	<div class="search_box_body_div" align="center">
		<div class="">
			<b>Interested to know more?</b>
		<br/>
			<a href="mailto:bookmeagame@gmail.com?Subject=Hello%20again" target="_top">Drop us a line</a>
		</div>
		<hr/>
		<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fbookmeagame&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=21&amp;appId=198897853511008" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>
	</div>
	
</div>

<div id="preload_div">
<img src="img/loading.gif" alt="Loading">
</div>
</div>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50650321-1', 'bookmeagame.com');
  ga('send', 'pageview');

</script>
</body>

</html>
