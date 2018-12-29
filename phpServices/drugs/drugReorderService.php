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

if (isset($_SESSION['appointmentID'])) {
    $appointmentID = $_SESSION['appointmentID'];
}
if (isset($_SESSION['patientCode'])) {
    $patientCode = $_SESSION['patientCode'];
}

$someJSON = $_POST['jsonString'];



$prescriptionData = json_decode($someJSON, true);

echo $prescriptionData. "\n";

$drugList = $prescriptionData["drugList"];

$count = 1;
foreach($drugList as $item) { //foreach element in $arr
    $id =  $item["id"];
    mysql_query("UPDATE `drug_prescription` SET presNum = $count WHERE `id` =$id");
    echo "UPDATE `drug_prescription` SET presNum = $count WHERE `id` =$id \n";
    $count++;
}

?>