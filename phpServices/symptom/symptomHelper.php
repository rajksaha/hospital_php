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
$date=date("Y-m-d");
$query_no=  $_POST['query'];


if($query_no== 0){	
	$sql = mysql_query("select symptomID,name from symptom order by name asc");
	$data = array();
	while ($row=mysql_fetch_array($sql)){
		array_push($data,$row);
	}
	echo json_encode($data);
}elseif ($query_no == 1){
	$symptom_id = $_POST['symptom_id'];
	$sql = "DELETE FROM symptom WHERE symptomID = $symptom_id";
	mysql_query($sql);	
	echo $sql;
}elseif ($query_no == 2){
	$symptom_id = $_POST['symptom_id'];
	$symptomName = $_POST['symptomName'];
	$sql = mysql_query("UPDATE symptom  SET name= '$symptomName' WHERE symptomID = $symptom_id ");
	echo $sql;
}




?>