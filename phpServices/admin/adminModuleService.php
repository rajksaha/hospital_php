<?php
session_start();
include('../config.inc');
if (!isset($_SESSION['username'])) {
	header('Location: index.php');
}
$username = $_SESSION['username'];
$doctorID = $_SESSION['doctorID'];
$date=date("Y-m-d");
$query_no=  $_POST['query'];


if($query_no== 0){	
	$sql = mysql_query("SELECT * FROM `user_profile` WHERE `doctorID` = $doctorID");
	$data = array();
	while ($row=mysql_fetch_array($sql)){
		array_push($data,$row);
	}
	echo json_encode($data);
}elseif ($query_no == 1){
	$user_id = $_POST['user_id'];
	$sql = "SELECT aa.`accessID`, aa.`accessCode`, aa.`accessDesc`, aa.`accessType`, aa.`parentAccessID`, ua.`userAccessId` 
            FROM `app_access` aa 
            LEFT JOIN user_access ua ON ua.`accessID` = aa.`accessID`
            WHERE ua.`userID` =  $user_id";
    while ($row=mysql_fetch_array($sql)){
        array_push($data,$row);
    }
    echo json_encode($data);
}elseif ($query_no == 2){
    $user_id = $_POST['user_id'];
    $sql = "SELECT aa.`accessID`, aa.`accessCode`, aa.`accessDesc`, aa.`accessType`, aa.`parentAccessID`, ua.`userAccessId` 
            FROM `app_access` aa 
            JOIN user_access ua ON ua.`accessID` = aa.`accessID`
            WHERE ua.`userID` =  $user_id";
    while ($row=mysql_fetch_array($sql)){
        array_push($data,$row);
    }
    echo json_encode($data);
}elseif ($query_no == 3){
    $user_id = $_POST['user_id'];

    // create user profile
    //create user access


    echo json_encode($data);
}else if ($query_no == 4){

    //update user profile
    //delete user access

    mysql_query("DELETE FROM `user_access` WHERE `userID` = $user_id ");
    //create user access
}

?>