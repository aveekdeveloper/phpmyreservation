<?php

// MongoDB
try{
	if($global_app_mode === 'DEVELOPMENT')
	{
		$connection = new MongoClient($global_mongo_url);
	}else
	{
		$connection = new Mongo(getenv("MONGOLAB_URI"));
	}
	
}catch(MongoException $e)
{
  echo "Could not connect to database";
  error_log( "Could not connect to database" );
  exit;
}

$db = $connection->$global_dbname; 

include_once('playground_functions_mongo.php');
include_once('userfunctions_mongo.php');
include_once('utilityFunctions.php');

?>
