<?php

session_start();
include('../config.inc');
include('../commonServices/prescriptionService.php');
include('../commonServices/prescriptionInsertService.php');
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}
$username = $_SESSION['username'];
$doctorID = $_SESSION['doctorID'];
$appointmentID = $_SESSION['appointmentID'];
$patientCode = $_SESSION['patientCode'];
$patientID = $_SESSION['patientID'];
$date=date("Y-m-d");
$query_no=  $_POST['query'];


if($query_no== 0){

    $sql = mysql_query("SELECT  ird.`reportDate`
                                FROM `inv_report_date` ird
                                WHERE `patientId` = $patientID GROUP BY   ird.`reportDate` ORDER BY ird.`reportDate` DESC");


    $data = array();
    while ($row=mysql_fetch_array($sql)){
        array_push($data,$row);
    }

    echo json_encode($data);
}elseif ($query_no == 1){

    $formattedDate = $_POST['formattedDate'];

    $sql = mysql_query("SELECT  `reportDate`, `reportLocation`, `fileName`, `ext`
                                FROM `inv_report_date` ird
                                WHERE `patientId` = $patientID AND  ird.`reportDate` = '$formattedDate'");

    $data = array();
    while ($row=mysql_fetch_array($sql)){
        array_push($data,$row);
    }

    echo json_encode($data);

}elseif ($query_no == 2){

    $invId = $_POST['invId'];
    $reportDate = $_POST['reportDate'];
    $reportDesc = $_POST['reportDesc'];
    $reportLocation = "";
    $sql = mysql_query("INSERT INTO `inv_report_date`(, `patientId`, `invId`, `reportDate`, `reportDesc`, `reportLocation`) VALUES ($patientID,$invId,'$reportDate','$reportDesc','$reportLocation')");



}elseif ($query_no == 3){

    $savedreportID = $_POST['savedreportID'];
    $invResult = $_POST['invResult'];
    $invStatus = $_POST['invStatus'];
    $sql = mysql_query("UPDATE `inv_report` SET `result`= '$invResult',`status`= $invStatus WHERE `id` = '$savedreportID'");

    echo "UPDATE `inv_report` SET `result`= '$invResult',`status`= $invStatus WHERE `id` = '$savedreportID'";
}


?>