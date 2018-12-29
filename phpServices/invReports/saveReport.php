<?php

	session_start();
	include('../config.inc');
	include('../commonServices/prescriptionInsertService.php');
	$username = $_SESSION['username'];
	$patientCode = $_SESSION['patientCode'];
    $patientID = $_SESSION['patientID'];

    $reportDate = $_POST['reportDate'];
    $extension = $_POST['extension'];
    $fileName = $_POST['fileName'];

    makeDir("./../../images/invReport/" . $patientCode);
    $target_dir = "./../../images/invReport/" . $patientCode . "/" . $reportDate. "/";
    makeDir($target_dir);

    $newFileName = generateRandomString() .  "." . $extension;
    $target_file = $target_dir . $newFileName;
     unlink($target_file);
     move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    $dbLocation = "images/invReport/" . $patientCode . "/" . $reportDate . "/" . $newFileName;

    $sql = mysql_query("INSERT INTO `inv_report_date`(`patientId`, `reportDate`, `reportLocation`, `fileName`, `ext`) VALUES ($patientID,'$reportDate','$dbLocation', '$newFileName', '$extension')");

function makeDir($path)
{
    return is_dir($path) || mkdir($path);
}

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

?>

