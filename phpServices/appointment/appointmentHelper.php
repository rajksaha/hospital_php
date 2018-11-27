<?php

session_start();
include('../config.inc');
include('../commonServices/appointmentService.php');

if (!isset($_SESSION['username'])) {
	header('Location: index.php');
}

$username=$_SESSION['username'];
$date=date("Y-m-d");
$query_no=  $_POST['query'];
$time_now=mktime(date('h')+6,date('i'),date('s'));
$time=date('h:i:s',$time_now);
$date=date("y-m-d");
$doctorID = $_SESSION['doctorID'];

if($query_no== 0){

	$sql=mysql_query("SELECT 
						d.doctorID, d.doctorCode, d.password, d.name, d.sex, d.age, d.phone, ds.category, ds.state, ds.prescriptionStyle, 
						ds.patientType, ds.patientState, ds.hospitalID, ds.photoSupport, ds.personCodeInitial, dc.name AS categoreyName, ds.pdfPage, ds.photoSupport
					FROM doctor d
					JOIN doctorsettings ds ON d.doctorID = ds.doctorID
					JOIN doctorcategory dc ON ds.category = dc.id
					WHERE d.doctorID =$doctorID");
	$rec=mysql_fetch_array($sql);
	echo json_encode($rec);
}

if($query_no==1){

	$filteredDate = $_POST['filteredDate'];
	echo getAppointment($doctorID, $filteredDate);
}

if($query_no==11){

	$filteredDate = $_POST['filteredDate'];
	echo getNextDateAppointment($doctorID, $filteredDate);
}


if($query_no==13){
	$type_search_str = $_POST['filteredDate'];
	echo getAppointmentByPatientType($doctorID, $type_search_str);
}

if($query_no==14){
	echo getAllPatient($doctorID);
}

if($query_no==15){

	$disease_search_str = $_POST['filteredDate'];

	echo getPatientByDisease($doctorID, $disease_search_str);
	
}


if($query_no==16){

	$drug_search_str = $_POST['filteredDate'];

	echo getPatientByDrugs($doctorID, $drug_search_str);
}




if($query_no==981){

	$disease_search_str = $_POST['filteredDate'];

	echo getAppointmentByDisease($doctorID, $disease_search_str);
	
}


if($query_no==888){

	$filteredDate = $_POST['filteredDate'];

	echo PatientAddd($doctorID, $filteredDate);
}


if($query_no==999){

	$drug_search_str = $_POST['filteredDate'];

	echo getAppointmentByDrugs($doctorID, $drug_search_str);
}

if($query_no==99){

	$filteredDate = $_POST['filteredDate'];
	$endDate= $_POST['endDate'];

	echo getAppointmentByDateRange($doctorID, $filteredDate, $endDate);
}

if($query_no==2){
	$patientCode = mysql_real_escape_string($_POST['dotorPatInitial']);
	$doctorCode=$_POST['doctorCode'];
	$doctorID=$_POST['doctorID'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$occupation = $_POST['occupation'];
	$age = $_POST['age'];
	$sex= $_POST['sex'];
	$phone = $_POST['phone'];
	$referredBy = $_POST['referredBy'];

	$appointmentType =  0;
	$sql="INSERT INTO `patient`( `patientCode`, `name`, `age`, `sex`, `occupation`, `address`, `phone`,`referredBy`) VALUES ( '$patientCode', '$name', '$age' , '$sex','$occupation', '$address', '$phone', '$referredBy')";

	mysql_query($sql);

	$data = addAppointMent($doctorCode, $patientCode, $appointmentType,$doctorID, $date, $time, $username);
	$today = date("Ym");
	$ra=rand(333 , 9999);
	$rando="".$today."".$ra."";
	$sql1= mysql_query("Select * from `appointment` where `patientCode` ='$rando'");
	if(mysql_num_rows($sql1)>0)
	{
		mysql_query("UPDATE `doctorsettings` SET `personCodeInitial`=  $rando+3 WHERE doctorID = $doctorID");
		echo $data;
	}
	else
	{
		mysql_query("UPDATE `doctorsettings` SET `personCodeInitial`=  $rando WHERE doctorID = $doctorID");
		echo $data;
	}
}
else if($query_no==3){
	$date = $_POST['filteredDate'];
	$doctorCode= $_POST['doctorCode'];
	$patientCode = $_POST['patientCode'];
	$doctorID=$_POST['doctorID'];
	$appointmentType =  1;
	$data = addAppointMent($doctorCode, $patientCode, $appointmentType,$doctorID, $date, $time, $username);
	echo $data;
}
else if($query_no==4){
	$_SESSION['appointmentID']=$_POST['appointmentID'];
	$_SESSION['patientCode']=$_POST['patientCode'];
	$_SESSION['patientID']=$_POST['patientID'];

}else if($query_no==5){
	$queryString=$_POST['data'];
	$sql ="SELECT `patientID`, `patientCode`, `name`, `age`, `sex`, `address`, `phone` FROM `patient` WHERE name LIKE '%" . $queryString . "%' LIMIT 10";
	$result=mysql_query($sql);
	//echo $sql;
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
}else if($query_no==6){
	session_destroy();

}else if($query_no==7){
	$queryString=$_POST['data'];
	$sql ="SELECT `patientID`, `patientCode`, `name`, `age`, `sex`, `address`, `phone` FROM `patient` WHERE patientCode LIKE '%" . $queryString . "%' LIMIT 10";
	$result=mysql_query($sql);
	//echo $sql;
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);



}
else if($query_no==77){
	$queryString=$_POST['data'];
	$sql ="SELECT `id`, `name` FROM `disease` WHERE name LIKE '%" . $queryString . "%' LIMIT 10";
	$result=mysql_query($sql);
	//echo $sql;
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
}else if($query_no==168){
	$queryString=$_POST['data'];
	$sql ="SELECT Distinct `drugName` FROM `drug_history` WHERE drugName LIKE '%" . $queryString . "%'";
	$result=mysql_query($sql);
	//echo $sql;
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
}else if($query_no==75){
	$queryString=$_POST['data'];
	$sql ="SELECT distinct drugName as name FROM drug WHERE drugName LIKE '%" . $queryString . "%' LIMIT 10";
	$result=mysql_query($sql);
	//echo $sql;
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
}else if($query_no==12){
	$queryString=$_POST['data'];
	$sql ="SELECT distinct typeName as name FROM patient_type WHERE typeName LIKE '%" . $queryString . "%' LIMIT 10";
	$result=mysql_query($sql);
	//echo $sql;
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
}
else if($query_no==68){
	$queryString=$_POST['data'];
	$sql ="SELECT Distinct `patientCode` FROM `appointment` WHERE patientCode LIKE '%" . $queryString . "%' order by patientCode ASC LIMIT 10 ";
	$result=mysql_query($sql);
	//echo $sql;
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
}else if($query_no==8){
	$queryString=$_POST['data'];
	$sql ="SELECT `patientID`, `patientCode`, `name`, `age`, `sex`, `address`, `phone` FROM `patient` WHERE phone LIKE '%" . $queryString . "%' LIMIT 10";
	$result=mysql_query($sql);
	//echo $sql;
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
}else if($query_no==9){
	$appointmentID=$_POST['appointmentID'];
	mysql_query("DELETE FROM `appointment` WHERE `appointmentID` = $appointmentID");
}else if($query_no==10){
	$appointmentID=$_POST['appointmentID'];
	mysql_query("UPDATE `appointment` SET`status`= 2 WHERE `appointmentID` = $appointmentID");
}
?>
