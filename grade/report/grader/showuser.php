<?php
/*********************************
 * On going development
*
*/

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

// get enrolled users

$query = "SELECT * FROM mdl_user WHERE username LIKE '%" . $s . "%'";

$squery = mysql_query($query);
if((mysql_num_rows($squery) != 0) && ($s != "")){
	while($sLookup = mysql_fetch_array($squery)){
		$displayName = $sLookup["firstname"];
		$lastName= $sLookup["lastname"];
		$lastName= substr($lastName,0,-1);
		$output .= '<li  style ="border:1px solid #f2f2f2; list-style: none; background-color:EBEBEB; padding:6px;" 
				onclick="sendToSearch(\'' . $displayName ." " .$lastName.'\')"> <a href = "#">' .$displayName. " " .$lastName.'</a></li>';
	}
}
	
echo $output;


?>
 