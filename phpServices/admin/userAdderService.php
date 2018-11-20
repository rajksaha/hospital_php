<?php

session_start();
include('../config.inc');
//include('../JSON.php');
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}
$username=$_SESSION['username'];
$doctorID = $_SESSION['doctorID'];
$date=date("Y-m-d");


$someJSON = $_POST['json'];



$userProfile = json_decode($someJSON, true);

$fullName = $userProfile["fullName"];
$addedUserName =  $userProfile["username"];
$addedPassword = $userProfile["password"];
$userAccessList = $userProfile["accessList"];

$userProfileId = $userProfile['userID'];

if($userProfileId == null){
    $result = mysql_query("SELECT * FROM `user_profile` WHERE `username` = '$addedUserName'");
    $rec=mysql_fetch_assoc($result);

    if($rec != ""){
        echo -1;
        return;
    }
    $createUser = "INSERT INTO `user_profile`( `username`, `password`, `doctorID`, `userType`, `fullName`, `isActive`) VALUES ('$addedUserName','$addedPassword',$doctorID,'USER','$fullName',1)";
    mysql_query($createUser);
    $userProfileId = mysql_insert_id();
    echo "\n $createUser ";
}else{
    //echo "/n test else ";
    $updateUser = "UPDATE `user_profile` SET `password`='$addedPassword',`fullName`='$fullName'  WHERE `userID` = $userProfileId ";
    mysql_query($updateUser);
    mysql_query("DELETE FROM `user_access` WHERE `userID` = $userProfileId ");
}

//echo $userAccessList;
if($userProfileId != null){
    foreach($userAccessList as $item) { //foreach element in $arr
        $subList =  $item["subAccessList"];
        foreach($subList as $subItem) {
            $haveAccess = $subItem['haveAccess'];
            if($haveAccess == 1 || $haveAccess == true){
                $accessID = $subItem["accessID"];
                mysql_query("INSERT INTO `user_access`(`userID`, `accessID`) VALUES ($userProfileId,$accessID)");
                echo "\n INSERT INTO `user_access`(`userID`, `accessID`) VALUES ($userProfileId,$accessID)\") ";
            }
        }
    }
}








?>