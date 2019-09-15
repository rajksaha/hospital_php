<?php

session_start();
include('../config.inc');
include('../commonServices/prescriptionService.php');
include('../commonServices/prescriptionInsertService.php');
include('../commonServices/parentInsertService.php');

if (!isset($_SESSION['username'])) {
	header('Location: index.php');
}
if (isset($_SESSION['appointmentID'])) {
	$appointmentID = $_SESSION['appointmentID'];
}
if (isset($_SESSION['patientCode'])) {
	$patientCode = $_SESSION['patientCode'];
}
$username = $_SESSION['username'];
$doctorID = $_SESSION['doctorID'];


$date=date("Y-m-d");
$query_no=  mysql_real_escape_string($_POST['query']);


if($query_no== 1){
	$sql = "SELECT `id`, `bangla`, `pdf`, `english` FROM `drugdaytype` WHERE 1 = 1";
	$result=mysql_query($sql);
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	
	echo json_encode($data);
	
}else if($query_no==0){
	$sql = "SELECT `id`, `name`, `initial`, `unit`, `unitInitial`, `optionalUnitInitial` FROM `drugtype` WHERE 1 = 1";
	$result=mysql_query($sql);
	
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	
	echo json_encode($data);
}else if($query_no==2){
	$sql = "SELECT `id`, `bangla`, `english`, `pdf` FROM `drugWhenType` WHERE 1 = 1";
	$result=mysql_query($sql);
	
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	
	echo json_encode($data);
}else if($query_no==3){

	$sql = "SELECT dat.id AS drugAdviceID, dat.bangla, dat.english, dat.pdf
			FROM `drugAdviceType` dat
			WHERE dat.doctorType =0
			UNION
			SELECT dat.id AS drugAdviceID, dat.bangla, dat.english, dat.pdf
			FROM `drugAdviceType` dat
			LEFT JOIN doctorsettings ds ON dat.doctorType = ds.category
			WHERE ds.doctorID = $doctorID ";
	$result=mysql_query($sql);
	
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	
	echo json_encode($data);
}else if($query_no==5){
	
	$drugPrescribeID = $_POST['drugPrescribeID'];
	$drugType = $_POST['drugType'];
	$drugStr = $_POST['drugStr'];
	$drugName = $_POST['drugName'];
	$drugID = getDrugIDByName($drugName, $drugType, $drugStr);
	$drugTime = $_POST['drugTime'];
	$doseUnit = $_POST['doseUnit'];
	$drugWhen = $_POST['drugWhen'];
	$drugAdvice = $_POST['drugAdvice'];
	
	$sql = "UPDATE `drug_prescription` SET  
				`drugTypeID`='$drugType',
				`drugID`='$drugID',
				`drugTimeID`='$drugTime',
				`drugDoseUnit`='$doseUnit',
				`drugWhenID`='$drugWhen',
				`drugAdviceID`='$drugAdvice' 
			WHERE `id` = '$drugPrescribeID'";
	
	mysql_query($sql);
	mysql_query("DELETE FROM `dose_period` WHERE `drugPrescribeID` = $drugPrescribeID");
}else if($query_no==6){
	
	
	$drugType = $_POST['drugType'];
	$drugStr = $_POST['drugStr'];
	$drugName = $_POST['drugName'];
	$drugID = getDrugIDByName($drugName, $drugType,$drugStr);
	$drugTime = $_POST['drugTime'];
	$doseUnit = $_POST['doseUnit'];
	$drugWhen = $_POST['drugWhen'];
	$drugAdvice = $_POST['drugAdvice'];
	$presNum = $_POST['presNum'];
	
	$result = insertPrescriptionDrugs($appointmentID, $drugType, $drugID, $drugTime, $doseUnit, $drugWhen, $drugAdvice, $presNum);
	
	echo $result;
	
}
else if($query_no==4){
	
	$result = getPresCribedDrugs($appointmentID);
	$data = array();
	
	while ($row=mysql_fetch_array($result)){
		$drugPrescribeID = $row['id'];
		
		$row['preiodicList'] = getPreiodicList($drugPrescribeID);
		array_push($data,$row);
	}
	echo json_encode($data);
            
	
}elseif ($query_no == 7){
	$drugPrescribeID = $_POST['drugPrescribeID'];
	
	mysql_query("DELETE FROM `drug_prescription` WHERE id='$drugPrescribeID'");
	mysql_query("DELETE FROM `dose_period` WHERE `drugPrescribeID` = $drugPrescribeID");
}elseif ($query_no == 8){
	
	$queryString=$_POST['drugName'];
	$drugType = $_POST['drugType'];
	
	$sql ="SELECT d.`drugID`, d.`typeID`, d.`companyID`, CONCAT(d.drugName, ' - ',  d.`strength`) As displayName, d.drugName, d.`strength`
			FROM `drug` d 
			LEFT JOIN drug_prescription dp  ON d.drugID = dp.drugID AND dp.appointMentID = '$appointmentID' AND  IFNULL(dp.appointMentID , 0)  = 0
			WHERE d.`drugName` LIKE '" . $queryString . "%' AND d.typeID = '$drugType'
			LIMIT 10";
	$result=mysql_query($sql);
	 $data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data); 
}elseif ($query_no == 9){
	
	$queryString=$_POST['drugName'];
	$drugType = $_POST['drugType'];
	$drugName = "";
	$drugStr = "";
	$drugNameStr = explode(",",$queryString);
	for ($i = 0; $i< sizeof($drugNameStr);$i++){
		if($i == 0){
			$drugName = $drugNameStr[$i];
		}else if($i == 1){
			$drugStr = $drugNameStr[$i];
		}
	}
	
	$sql ="INSERT INTO `drug`( `typeID`, `companyID`, `drugName`, `strength`) VALUES ('$drugType',0,'$drugName','$drugStr')";
	mysql_query($sql);
	echo mysql_insert_id();
}elseif ($query_no == 10){
	
	$drugID = $_POST['drugID'];
	
	$sql ="DELETE FROM `drug` WHERE `drugID` = '$drugID'";
	mysql_query($sql);
	
	mysql_query("DELETE FROM `drug_prescription` WHERE `drugID` = '$drugID'");
}elseif ($query_no == 11){
	
	$drugID = $_POST['drugID'];
	$queryString=$_POST['drugName'];
	$sql ="UPDATE `drug` SET `drugName`='$queryString'  WHERE `drugID` = '$drugID'";
	mysql_query($sql);
}else if($query_no == 12){
	
	$drugDose = $_POST['dose'];
	$drugNoOfDay = $_POST['numOfDay'];
	$drugDayType = $_POST['durationType'];
	$drugPrescribeID = $_POST['drugPrescribeID'];
	
	mysql_query("INSERT INTO `dose_period`(`drugPrescribeID`, `dose`, `numOfDay`, `durationType`) VALUES ($drugPrescribeID,'$drugDose', $drugNoOfDay ,'$drugDayType')");

}else if($query_no == 13){
	
	$drugID = $_POST['drugID'];
	
	$sql = mysql_query("SELECT `doctorDrugID`, `doctorID`, `drugID`, `drugTimeID`, `drugDoseUnit`, `drugWhenID`, `drugAdviceID` 
				FROM `doctor_drug` dd
				WHERE dd.doctorID = $doctorID AND dd.drugID = $drugID");
	
	$result = mysql_fetch_assoc($sql);
	if($result && $result['doctorDrugID'] != null){
		$result['preiodicList'] = getDrugPreiodicList($result['doctorDrugID']);
	}
	
	if($result){
		echo json_encode($result);
	}else{
		return  false;
	}
	
}else if($query_no==14){
	
	
	$drugType = $_POST['drugType'];
	$drugStr = $_POST['drugStr'];
	$drugName = $_POST['drugName'];
	$drugID = getDrugIDByName($drugName, $drugType,$drugStr);
	$drugTime = $_POST['drugTime'];
	$doseUnit = $_POST['doseUnit'];
	$drugWhen = $_POST['drugWhen'];
	$drugAdvice = $_POST['drugAdvice'];
	

	mysql_query("DELETE FROM `doctor_drug_dose` WHERE `doctorDrugID`IN (SELECT `doctorDrugID` FROM `doctor_drug` WHERE WHERE `doctorID` = $doctorID AND `drugID` = $drugID)");
	mysql_query("DELETE FROM `doctor_drug` WHERE `doctorID` = $doctorID AND `drugID` = $drugID");
	
	$result = insertDoctorDrug($doctorID, $drugID, $drugTime, $doseUnit, $drugWhen, $drugAdvice);
	
	echo $result;
	
}else if($query_no == 15){
	
	$drugDose = $_POST['dose'];
	$drugNoOfDay = $_POST['numOfDay'];
	$drugDayType = $_POST['durationType'];
	$doctorDrugID = $_POST['doctorDrugID'];
	
	insertDoctorDrugDose($doctorDrugID, $drugDose, $drugNoOfDay, $drugDayType);
	
	echo "INSERT INTO `doctor_drug_dose`(
				`doctorDrugID`, 
				`dose`, 
				`numOfDay`, 
				`durationType`
			) 
			VALUES (
				$doctorDrugID,
				'$drugDose',
				$drugNoOfDay,
				$drugDayType
				)";
	
}

function getDrugPreiodicList($doctorDrugID){
	
	$dose = mysql_query("SELECT `dose`, `numOfDay`, `durationType` FROM `doctor_drug_dose` WHERE `doctorDrugID` = $doctorDrugID");
		
	$data = array();
	while ($row=mysql_fetch_array($dose)){
		array_push($data,$row);
	}
	
	return $data;
}

function getPreiodicList($drugPrescribeID){
	
	$dose = mysql_query("SELECT `drugPrescribeID`, `dose`, `numOfDay`, `durationType` FROM `dose_period` WHERE `drugPrescribeID` = $drugPrescribeID");
			
		$data = array();
		while ($row=mysql_fetch_array($dose)){
			array_push($data,$row);
		}
		
		return $data;
}
	
?>