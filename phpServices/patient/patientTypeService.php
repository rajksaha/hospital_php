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


$query_no=  mysql_real_escape_string($_POST['query']);

if($query_no== 0){
    $result = mysql_query("SELECT  `category` FROM `doctorsettings` WHERE `doctorID` = $doctorID");
    $rec=mysql_fetch_assoc($result);
    echo "SELECT  `category` FROM `doctorsettings` WHERE `doctorID` = $doctorID";
    if($rec == ""){
        echo -1;
        return;
    }
    return  $rec['category'];
}elseif ($query_no == 1){
    $doctorType = $_POST['doctorType'];
    $name = $_POST['name'];
    mysql_query("INSERT INTO `patient_type`(`doctorType`, `typeName`) VALUES ($doctorType,'$name')");
    echo mysql_insert_id();
}elseif ($query_no == 2){
    $id = $_POST['id'];
    $name = $_POST['name'];
    mysql_query("UPDATE `patient_type` SET`typeName`='$name' WHERE `id` = $id");
}elseif ($query_no == 3){
    $id = $_POST['id'];
    mysql_query("DELETE FROM `patient_type` WHERE  `id` = $id");
}if($query_no==4){
       	$doctorType = $_POST['doctorType'];
       	$sql = "SELECT `id`, `doctorType`, `typeName` FROM `patient_type` WHERE doctorType = '$doctorType'";
       	$result=mysql_query($sql);

       	$data = array();
       	while ($row=mysql_fetch_array($result)){
       		array_push($data,$row);
       	}

       	echo json_encode($data);


}if($query_no==5){

      $result = mysql_query("SELECT ds.`category`
  				FROM `doctor` d
  				JOIN  doctorsettings ds ON d.doctorID = ds.doctorID
  				WHERE d.`doctorID` = '$doctorID'");

  	$rec = mysql_fetch_assoc($result);
   	$doctorType = $rec['category'];

   	echo $doctorType;
   }
   if($query_no==6){

   	$doctorType = $_POST['doctorType'];
   	$sql = "SELECT `id`, `doctorType`, `typeName` FROM `patient_type` WHERE doctorType = '$doctorType'";
   	$result=mysql_query($sql);

   	$data = array();
   	while ($row=mysql_fetch_array($result)){
   		array_push($data,$row);
   	}

   	echo json_encode($data);


   }
?>