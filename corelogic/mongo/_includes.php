<?php

// MongoDB
$connection = new MongoClient($global_mongo_url);

try{
$db = $connection->$global_dbname;   
}catch(MongoException $e)
{
  echo "Could not connect to database";
  exit;
}

include_once('playground_functions_mongo.php');
include_once('userfunctions_mongo.php');
include_once('utilityFunctions.php');

?>
