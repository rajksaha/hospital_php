<?php
/**
 * Created by PhpStorm.
 * User: raj
 * Date: 12/10/2018
 * Time: 3:17 PM
 */

session_start();
include('../config.inc');
include('../commonServices/appointmentService.php');

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}

$username=$_SESSION['username'];
$date=date("YYYY-MM-DD");
$time_now=mktime(date('h')+6,date('i'),date('s'));
$time=date('h:i:s',$time_now);
$date=date("y-m-d");
$doctorID = $_SESSION['doctorID'];

$query_no=  $_POST['query'];

if($query_no == 0){

    $sql = "SELECT app.`appointmentType` , pat.sex
                                    FROM `appointment` app
                                    JOIN `patient` pat ON app.`patientCode` = pat.`patientCode`
                                    JOIN `doctor` doc ON app.`doctorCode` = doc.`doctorCode`
                                    WHERE doc.`doctorID` = $doctorID and app.`date` = '$date'";
    $result = mysql_query($sql);

    $newPatient = 0;
    $oldPatient = 0;
    $freePatient = 0;
    $newPatient = 0;
    $relative = 0;
    $report = 0;

    $male = 0;
    $feMale = 0;

    while ($row=mysql_fetch_array($result)){
        $appType = $row['appointmentType'];
        $sex = $row['sex'];

        if($sex == 'MALE'){
            $male++;
        }else{
            $feMale++;
        }

        if($appType == 0){
            $newPatient++;
        }elseif ($appType == 1){
            $oldPatient++;
        }elseif ($appType == 2){
            $freePatient++;
        }elseif ($appType == 3){
            $relative++;
        }elseif ($appType == 4){
            $report++;
        }
    }

    $respObj->newPatient = $newPatient;
    $respObj->oldPatient = $oldPatient;
    $respObj->freePatient = $freePatient;
    $respObj->relative = $relative;
    $respObj->report = $report;
    $respObj->male = $male;
    $respObj->feMale = $feMale;

    echo json_encode($respObj);
}


?>
