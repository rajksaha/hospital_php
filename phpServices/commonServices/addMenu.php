<?php

$hostname = 'localhost';        // Your MySQL hostname. Usualy named as 'localhost', so you're NOT necessary to change this even this script has already online on the internet.
$dbname   = 'doctorplatform'; // Your database name.
$username = 'root';             // Your database username.
$password = '';                 // Your database password. If your database has no password, leave it empty.

// Let's connect to host
mysql_connect($hostname, $username, $password) or DIE('Connection to host is failed, perhaps the service is down!');
// Select the database
mysql_select_db($dbname) or DIE('Database name is not available!');
mysql_query('SET CHARACTER SET utf8');
mysql_query("SET SESSION collation_connection ='utf8_general_ci'") or die (mysql_error());
?>
<?php


$result = mysql_query("SELECT `id`, `menuID`, `menuURL`, `defaultName`, `inPrescription`, `displayOrder` FROM `menu` WHERE `inPrescription` = true ORDER BY displayOrder");

$doctorID = 13;
while ($row = mysql_fetch_array($result)){
	$menuId = $row['menuID'];
	$name = $row['defaultName'];
	$displayOrder = $row['displayOrder'];
	mysql_query("INSERT INTO `menusettings`( `doctorID`, `menuID`, `menuHeader`, `order`) VALUES ($doctorID,$menuId,'$name',$displayOrder)");
}

echo "done";
?>