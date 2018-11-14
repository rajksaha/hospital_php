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
	$sql = mysql_query("select id,name from disease order by name asc");
	$data = array();
	while ($row=mysql_fetch_array($sql)){
		array_push($data,$row);
	}
	echo json_encode($data);
}elseif ($query_no == 1){
	$disease_id = $_POST['disease_id'];
	$sql = "DELETE FROM disease WHERE id = $disease_id";
	mysql_query($sql);	
	echo $sql;
}elseif ($query_no == 2){
	$disease_id = $_POST['disease_id'];
	$diseaseName = $_POST['diseaseName'];
	$sql = mysql_query("UPDATE disease  SET name= '$diseaseName' WHERE id = $disease_id ");
	echo $sql;
}

?>