<?php

// MongoDB
try{
	$connection = new MongoClient($global_mongo_url);
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
