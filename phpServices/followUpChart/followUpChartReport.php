<?php
/**
 * Created by PhpStorm.
 * User: raj
 * Date: 1/29/2019
 * Time: 2:57 PM
 */

session_start();
include('../config.inc');

$query_no=  $_POST['query'];


if($query_no == 0){

    $startDate =  $_POST['startDate'];
    $endDate =  $_POST['endDate'];
    $invId =  $_POST['invId'];
    $patientId =  $_POST['patientId'];

    $sql = "SELECT fur.`resultID` , fur.`followUpID` , fur.`data` , fur.`entryDate` , inv.`name` AS invName, p.name AS patientName
        FROM  `follow_up_result` fur
        JOIN  `patient_follow_up` pfu ON fur.`followUpID` = pfu.`patientFollowUpID` 
        JOIN  `inv` inv ON inv.id = pfu.invID
        JOIN  `patient` p ON pfu.patientID = p.patientID
        WHERE 1 =1 ";

    if($invId != ""){
        $sql = $sql . " AND pfu.invID = $invId ";
    }

    if($patientId != ""){
        $sql = $sql . " AND pfu.patientID = $patientId ";
    }

    if($startDate != "" && $endDate != ""){
        $sql = $sql . " AND fur.`entryDate` IN BETWEEN (DATE('$startDate'), DATE('$endDate')) ";
    }elseif ($startDate != ""){
        $sql = $sql . " AND fur.`entryDate` = DATE('$startDate') ";
    }elseif ($endDate != ""){
        $sql = $sql . " AND fur.`entryDate` = DATE('$endDate') ";
    }

    $result = mysql_query($sql);

    $data = array();
    while ($row=mysql_fetch_array($result)){
        array_push($data,$row);
    }

    echo json_encode($data);



}






?>