<?php

//database connections
$hostname = "localhost";
$user = "root";
$pass = "";
$database = "moodle";

$connection = mysql_connect($hostname, $user, $pass) or die(mysql_error());
mysql_select_db($database, $connection) or die(mysql_error());

$s = $_REQUEST["s"];
$output = "";
$s = str_replace(" ", "%", $s);
// echo $s;
$query = "INSERT INTO mdl_todolist(todo) VALUES ('$s')";
$squery = mysql_query($query);
if (!$squery) { // add this check.
	die('Invalid query: ' . mysql_error());
}
