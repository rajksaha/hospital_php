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
	
	$queryString = $_POST['invName'];
	
	$sql = "SELECT i.`id` , i.`name`
			FROM `inv` i
			WHERE i.`name` LIKE '" . $queryString . "%' ORDER BY i.`name` LIMIT 10 ";

	$result=mysql_query($sql);
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}

	echo json_encode($data);
}else if ($query_no == 1){
	
	$sql = "SELECT i.`id` , i.`name` , IFNULL( ip.id, 0 ) AS prescribedInvID, dis.id AS invSettingID, ip.id AS invPresID, i.categoryID,  dis.displayOrder
			FROM `inv` i
			LEFT JOIN inv_category ic ON ic.invCategoryID = i.categoryID 
			JOIN doctor_inv_setteing dis ON i.id = dis.invID
			LEFT JOIN inv_prescription ip ON dis.invID = ip.invID  AND ip.appointMentID = '$appointmentID'
			AND IFNULL( dis.id, 0 )
			WHERE dis.doctorID = '$doctorID' ORDER BY `name` ";
	
	$result=mysql_query($sql);
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	
	echo json_encode($data);
	
	
}else if ($query_no == 2){
	
	$invName= $_POST['invName'];
	
	$invID = getInvIDByName($invName);
	
	$displayOrder = $_POST['displayOrder'];
	
	$sql = "INSERT INTO `doctor_inv_setteing`( `doctorID`, `invID`, `displayOrder`) VALUES ('$doctorID','$invID','$displayOrder')";
	
	mysql_query($sql);
	
}else if ($query_no == 4){

	$invName= $_POST['invName'];
	
	$invID = getInvIDByName($invName);
	
	$note = $_POST['note'];

	echo insertPrescriptionInv($appointmentID, $invID, $note);

}else if ($query_no == 5){

	$id = $_POST['id'];

	$sql = "DELETE FROM `inv_prescription` WHERE id = '$id'";

	mysql_query($sql);

}else if ($query_no == 6){

	$invSettingID = $_POST['invSettingID'];

	$sql = "DELETE FROM `doctor_inv_setteing` WHERE `id` = '$invSettingID'";

	mysql_query($sql);
	
	echo $sql;

}else if ($query_no == 7){
	
	$result=getPrescribedInv($appointmentID);
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	echo json_encode($data);
	
	
}else if($query_no== 8){
	
	$queryString = $_POST['invName'];
	
	$sql = "SELECT i.`id` , i.`name`
			FROM `inv` i
			LEFT JOIN inv_prescription ip ON i.id = ip.invID
			AND ip.appointMentID = '$appointmentID' AND IFNULL( ip.id, 0 ) = 0
			WHERE i.`name` LIKE '" . $queryString . "%' LIMIT 10";

	$result=mysql_query($sql);
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}

	echo json_encode($data);
}else if ($query_no == 9){

	$invName= $_POST['invName'];
	
	$invID = getInvIDByName($invName);
	$note = $_POST['note'];
	$ID = $_POST['ID'];

	$sql = "UPDATE `inv_prescription` SET `invID`= '$invID' ,`note`= '$note'  WHERE `id` = '$ID'";

	mysql_query($sql);
	
	echo $sql;

}else if ($query_no == 10){

	$invID = $_POST['invID'];

	$sql = "DELETE FROM `inv_prescription` WHERE `appointMentID` = '$appointmentID' AND `invID` = '$invID'";

	mysql_query($sql);

}else if ($query_no == 11){
	
	$invName= $_POST['invName'];
	
	$invID = getInvIDByName($invName);
	
	$sql = "INSERT INTO `doctor_followUp_setteing`( `doctorID`, `invID`) VALUES ('$doctorID','$invID')";
	
	mysql_query($sql);
	
}else if ($query_no == 12){
	$sql = "SELECT dfs.`followUpSerttingID`, dfs.`doctorID`, dfs.`invID`, i.name AS invName
			FROM `doctor_followup_setteing` dfs
			JOIN inv i ON i.id = dfs.invID
			WHERE dfs.doctorID = '$doctorID'";
	
	$result=mysql_query($sql);
	
	$data = array();
	while ($row=mysql_fetch_array($result)){
		array_push($data,$row);
	}
	
	echo json_encode($data);
}else if ($query_no == 13){

	$id = $_POST['id'];

	$sql = "DELETE FROM `doctor_followup_setteing` WHERE `followUpSerttingID` = '$id'";

	mysql_query($sql);

}else if ($query_no == 15){


    $sql = "SELECT `invCategoryID`, `name` FROM `inv_category`";

    $result = mysql_query($sql);

    $data = array();
    while ($row=mysql_fetch_array($result)){
        array_push($data,$row);
    }

    echo json_encode($data);

}else if ($query_no == 16){


    $jsonArray = $_POST['invList'];

    $arr = json_decode($jsonArray, true);

    foreach ($arr as $item) {
        $categoryID = $item['categoryID'];
        $id = $item['id'];
        $name = $item['name'];
        mysql_query("UPDATE `inv` SET `categoryID`= $categoryID, `name` = '$name' WHERE id = $id");
    }

}else if ($query_no == 17){

    $categoryId = $_POST['categoryId'];

    $sql = "SELECT i.`id` , i.`name` , IFNULL( ip.id, 0 ) AS prescribedInvID, dis.id AS invSettingID, ip.id AS invPresID, i.categoryID,  dis.displayOrder
			FROM `inv` i
			JOIN doctor_inv_setteing dis ON i.id = dis.invID
			LEFT JOIN inv_category ic ON ic.invCategoryID = i.categoryID AND i.categoryID = $categoryId
			LEFT JOIN inv_prescription ip ON dis.invID = ip.invID  AND ip.appointMentID = '$appointmentID'
			AND IFNULL( dis.id, 0 )
			WHERE dis.doctorID = '$doctorID' ORDER BY `name` ";

    $result=mysql_query($sql);
    $data = array();
    while ($row=mysql_fetch_array($result)){
        array_push($data,$row);
    }

    echo json_encode($data);


}



?>