<?php

//Make an array with the information. 
$db['db_host'] =  "localhost"; 
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "cms";

//This loop will make constants. 
foreach($db as $key => $value) {
    define(strtoupper($key), $value);
}

//Connect to the database with the constants. 
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//Print a succes message if connect was success.
if ($connection) {
    //echo "Database Connection Succeeded.";
} else {
    echo "Database Connection Failed.";
}

?>