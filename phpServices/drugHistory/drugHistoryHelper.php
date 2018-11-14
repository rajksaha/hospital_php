<?php

session_start();
include('../config.inc');
include('../commonServices/appointmentService.php');
include('../commonServices/prescriptionService.php');
include('../commonServices/prescriptionInsertService.php');
include('../commonServices/parentInsertService.php');
if (!isset($_SESSION['username'])) {
	header('Location: index.php');
}
$username=$_SESSION['username'];
$date=date("Y-m-d");
$appointmentID = $_SESSION['appointmentID'];
$patientCode = $_SESSION['patientCode'];
//$query_no=  mysql_real_escape_string($_POST['query']);

$json = file_get_contents('php://input');
$dataObject = json_decode($json);

$query_no = $dataObject->query;

if($query_no==1){
	
	$result = getPatientInformaition($patientCode);
	
	$rec=mysql_fetch_assoc($result);
	
	$patientID = $rec['patientID'];
	
	$status = $dataObject->status;
	
	$contentType = 'CURRDRUGS';
	
	if ($status == 0) {
		$contentType = "OLDDRUGS";
	}

	$sql = "SELECT dh.`drugHistoryID`, dh.`patientID`, dh.`drugName`, dh.`currentStatus`, cd.contentDetailID, IF(cd.contentDetailID  IS NULL, false, true) AS addedToPres
			FROM `drug_history` dh
			LEFT JOIN contentdetail cd ON cd.contentType = '$contentType' AND cd.entityID = $appointmentID 
			WHERE dh.`patientID` = $patientID AND dh.`currentStatus` = $status";
            $result=mysql_query($sql);

            $data = array();
            while ($row=mysql_fetch_array($result)){
                array_push($data,$row);
            }
	
	echo json_encode($data);
	
}else if($query_no==2){
	
	$drugName = $dataObject->drugName;
	
	$result = getPatientInformaition($patientCode);
	
	$rec=mysql_fetch_assoc($result);
	
	$patientID = $rec['patientID'];
	
	$status = $dataObject->status;
	
	mysql_query("INSERT INTO `drug_history`(`patientID`, `drugName`, `currentStatus`) VALUES ('$patientID', '$drugName' , '$status')");
	
	
	
}else if($query_no==3){
	
	$delId = $dataObject->delId;
	
	mysql_query("DELETE FROM `drug_history` WHERE `drugHistoryID` = $delId");
	
}else if($query_no==4){
	$sql = "SELECT `id`, `bangla`, `english`, `pdf` FROM `drugWhenType` WHERE id <> 0";
	$result=mysql_query($sql);
	
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	
	echo json_encode($data);
	
}else if($query_no == 5){
	
	$bangla = $dataObject->bangla;
	$pdf = $dataObject->pdf;
	
	//$asciiString = mb_convert_encoding($bangla, "ISO-8859-1", "UTF-8");
	
	mysql_query("INSERT INTO `drugwhentype`(`bangla`, `english`, `pdf`) VALUES ('$bangla', '' , '$pdf' )");
	
	
	
}else if($query_no == 6){
	
	$delId = $dataObject->delId;
	
	mysql_query("DELETE FROM `drugwhentype` WHERE `id` = $delId");
	
}else if($query_no == 7){

	$drugName = $dataObject->drugName;
	$status = $dataObject->status;
	
	$contentType = 'CURRDRUGS';
	
	if ($status == 0) {
		$contentType = "OLDDRUGS";
	}

	echo insertContentDetail($appointmentID, $contentType, $drugName, "");

}else if($query_no == 8){

	$contentDetailID = $dataObject->contentDetailID;

	mysql_query("DELETE FROM `contentdetail` WHERE `contentDetailID` = $contentDetailID");

}

?>