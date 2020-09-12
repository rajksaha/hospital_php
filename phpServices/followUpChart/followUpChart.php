<?php

session_start();
include('../config.inc');
include('../commonServices/prescriptionService.php');
include('../commonServices/parentInsertService.php');
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
	echo getPatientFollowUpSetting($patientID, $doctorID);
}elseif ($query_no == 1){

    $invName= $_POST['invName'];

    $invID = getInvIDByName($invName);

    $pat = mysql_query("SELECT `id`, `patientID`, `type`, `tri`, `triStatus`, `edb` FROM `patient_detail` WHERE  `patientID` = $patientID");
    $res = mysql_fetch_assoc($pat);
    $patientTypeId= $res['type'];
    $sql = mysql_query("INSERT INTO `doctor_followUp_setteing`( `doctorID`, `patientTypeId`, `invID`) VALUES ('$doctorID', $patientTypeId, '$invID')");
    echo mysql_insert_id();
}elseif ($query_no == 4){

    $jsonArray= $_POST['jsonArray'];

    $arr = json_decode($jsonArray, true );

    foreach($arr as $item) {
        $followUpID = $item['followUpID'];
        $entryDate = $item['entryDate'];
        $data = $item['data'];
        mysql_query("DELETE FROM follow_up_result where followUpID = $followUpID AND entryDate = '$entryDate' AND appID = $appointmentID ");
        mysql_query("INSERT INTO `follow_up_result`( `appID`, `followUpID`, `entryDate`, `data`) VALUES ($appointmentID, $followUpID, '$entryDate', '$data')");
        echo "INSERT INTO `follow_up_result`( `appID`, `followUpID`, `entryDate`, `data`) VALUES ($appointmentID, $followUpID, '$entryDate', '$data')";
    }
    //echo $arr;

}elseif ($query_no == 2){
    $followUpID = $_POST['patientFollowUpID'];
    $appID = $_POST['appID'];
    $entryDate = $_POST['entryDate'];
    $invID = $_POST['invID'];

    $result = mysql_query("SELECT fur . *, i.name
                            FROM `follow_up_result` fur
                            JOIN `doctor_followup_setteing` dfs ON doctorID =$doctorID AND fur.followUpID = dfs.followUpSerttingID
                            JOIN inv i ON dfs.invID = i.id
                            WHERE `followUpID` =$followUpID
                            AND appID = $appID
                            AND dfs.invID =$invID
                            AND fur.entryDate = '$entryDate' ");

    $data = array();
    while ($row=mysql_fetch_array($result)){
        array_push($data,$row);
    }

    echo json_encode($data);
}elseif ($query_no == 3){

    $result = mysql_query("SELECT DISTINCT (fur.`entryDate`), fur.appID
                                FROM `follow_up_result` fur
                                JOIN `doctor_followup_setteing` dfs ON doctorID = $doctorID  AND fur.followUpID =dfs.followUpSerttingID
                                JOIN `appointment` app ON fur.appID = app.appointmentID
                                JOIN `patient` p ON app.patientCode = p.patientCode
                                JOIN `patient_detail` pd ON pd.patientID = p.patientID AND dfs.patientTypeId = pd.type
                                WHERE p.patientID = $patientID ORDER BY entryDate DESC");

    $data = array();
    while ($row=mysql_fetch_array($result)){
        array_push($data,$row);
    }

    echo json_encode($data);
}elseif ($query_no == 5) {

    $jsonArray = $_POST['jsonArray'];
    $entryDate = $_POST['entryDate'];

    $arr = json_decode($jsonArray, true);

    foreach ($arr as $item) {
        $data = $item['data'];
        mysql_query("DELETE FROM contentdetail where entityID = $appointmentID AND entityType = 'CLINICAL_RECORD' AND code = '$entryDate'");
        insertContentDetail($appointmentID, "CLINICAL_RECORD", $data, $entryDate);
    }
    echo true;
}



function getPatientFollowUpSetting($patientID, $doctorID){
	
	$sql = mysql_query("SELECT dfs.`followUpSerttingID`, dfs.`doctorID`, dfs.`patientTypeId`, dfs.`invID`, i.name AS invName
                FROM `doctor_followup_setteing` dfs
                JOIN `patient_detail` pd ON dfs.`patientTypeId` = pd.`type`
                JOIN inv i ON dfs.invID = i.id
			    WHERE pd.patientID = $patientID AND dfs.doctorID = $doctorID");
	
	$data = array();
	while ($row=mysql_fetch_array($sql)){
		array_push($data,$row);
	}
	
	return json_encode($data);
	
}

?>