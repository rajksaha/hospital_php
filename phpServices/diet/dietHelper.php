<?php

session_start();
include('../config.inc');
include('../commonServices/prescriptionService.php');
include('../commonServices/prescriptionInsertService.php');
include('../commonServices/autoCopmpleteService.php');

if (!isset($_SESSION['username'])) {
	header('Location: index.php');
}
$username = $_SESSION['username'];
$doctorId = $_SESSION['doctorID'];

if (isset($_SESSION['appointmentID'])) {
	$appointmentID = $_SESSION['appointmentID'];
}

if (isset($_SESSION['patientCode'])) {
	$patientCode = $_SESSION['patientCode'];
}

$query_no=  $_POST['query'];

if($query_no== 0){
	$queryString = $_POST['data'];
	return getDiet($queryString);
}

else if($query_no== 1){
	$result = getContentDetail($appointmentID, "DIET");
	$rec = mysql_fetch_assoc($result);
	echo json_encode($rec);
		

}
elseif ($query_no == 2){
	$dietName = $_POST['dietName'];
    insertContentDetail($appointmentID, "DIET", $dietName, "");
}

elseif ($query_no == 3){
    $dietName = $_POST['dietName'];
	$id = $_POST['id'];
    mysql_query("UPDATE `contentdetail` SET `detail`= '$dietName' WHERE `contentType` = 'DIET' AND `entityID` = $appointmentNO");
}
		
?>

