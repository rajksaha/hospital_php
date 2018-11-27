<?php
session_start();
include('../config.inc');
if (!isset($_SESSION['username'])) {
	header('Location: index.php');
}
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];
$userType = $_SESSION['userType'];
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
	$user_id = $_POST['userId'];
	$sql = mysql_query("SELECT aa.`accessID`, aa.`accessCode`, aa.`accessDesc`, aa.`accessType`, aa.`parentAccessID`, ua.`userAccessId`,
            CASE WHEN ua.`userAccessId` IS NULL THEN 0 ELSE 1 END AS haveAccess 
            FROM `app_access` aa 
            LEFT JOIN user_access ua ON ua.`accessID` = aa.`accessID` AND ua.`userID` =  $user_id ");

    $data = array();

    while ($row=mysql_fetch_array($sql)){
        array_push($data,$row);
    }
    echo json_encode($data);
}elseif ($query_no == 2){

    $sql = mysql_query("SELECT * FROM `user_profile` WHERE `userID` = $userID");
    $rec=mysql_fetch_assoc($sql);
    $temp = $rec['fullName'];
    $userProfile->fullName = $temp;
    if($userType != 'DOCTOR'){
        $sql = mysql_query("SELECT aa.`accessID`, aa.`accessCode`, aa.`accessDesc`, aa.`accessType`, aa.`parentAccessID`, ua.`userAccessId` 
            FROM `app_access` aa 
            JOIN user_access ua ON ua.`accessID` = aa.`accessID`
            WHERE ua.`userID` =  $userID");
        $data = array();
        while ($row=mysql_fetch_array($sql)){
            array_push($data,$row);
        }
        $userProfile->accessList = $data;
        echo json_encode($userProfile);
    }else{
        echo json_encode($userProfile);
    }
}elseif ($query_no == 3){

}else if ($query_no == 4){

    //update user profile
    //delete user access

    mysql_query("DELETE FROM `user_access` WHERE `userID` = $user_id ");
    //create user access
}else if ($query_no == 4){

    //update user profile
    //delete user access

    mysql_query("DELETE FROM `user_access` WHERE `userID` = $user_id ");
    //create user access
}elseif ($query_no == 5){
    $sql = "SELECT aa.`accessID`, aa.`accessCode`, aa.`accessDesc`, aa.`accessType`, aa.`parentAccessID` , 1 as haveAccess
            FROM `app_access` aa where 1 = 1 ";

    $result=mysql_query($sql);
    $data = array();
    while ($row=mysql_fetch_array($result)){
        array_push($data,$row);
    }
    echo json_encode($data);
}

?>