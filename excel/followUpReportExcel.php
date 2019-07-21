<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

session_start();
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';


include('../phpServices/config.inc');


$patientType = $_POST['patientTypeId'];

//echo $patientType . 'patientType';

$doctorID = $_SESSION['doctorID'];



$sql = mysql_query("SELECT `followUpSerttingID`, `doctorID`, `patientTypeId`, `invID` , i.name AS invName
            FROM `doctor_followup_setteing` pfu
			JOIN inv i ON pfu.invID = i.id
			WHERE pfu.patientTypeId = $patientType AND pfu.doctorID = $doctorID");

$followUpList = array();
while ($row=mysql_fetch_array($sql)){
    array_push($followUpList,$row);
}

$numOfFollowUp = sizeof($followUpList);

//echo $numOfFollowUp . 'numOfFollowUp' . "/n";


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'NAME')
    ->setCellValue('B1', 'AGE')
    ->setCellValue('C1', 'GENDER')
    ->setCellValue('D1', 'APPOINTMENT DATE')
    ->setCellValue('E1', 'BP')
    ->setCellValue('F1', 'PULSE')
    ->setCellValue('G1', 'FOLLOW-UP CHART');

$abc = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P");

$num = $abc[6+$numOfFollowUp];
$str = "G1:".$num. "1";
//echo $str;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells($str);

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue($abc[6].'2', "Report Date");
$fIndex = 7;
foreach($followUpList as $item) {
    //echo "\n" . $abc[$fIndex]  ;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($abc[$fIndex].'2', $item['invName']);
    $fIndex++;
}

//get followUp info by patient Type

$theQuery = "SELECT  `appID` , p.name AS patientName, p.age, p.sex, app.date, vp1.vitalResult AS bp, vp2.vitalResult pulse
FROM  `follow_up_result` fur
JOIN  `doctor_followup_setteing` dfs ON fur.`followUpID` = dfs.`followUpSerttingID` 
JOIN  `appointment` app ON fur.`appID` = app.`appointmentID`
JOIN  `patient` p ON p.patientCode = app.patientCode
JOIN  `patient_detail` pd ON pd.patientID = p.patientID
LEFT JOIN `vital_prescription` vp1 ON vp1.appointMentID = app.`appointmentID` AND vp1.vitalID = 107
LEFT JOIN `vital_prescription` vp2 ON vp2.appointMentID = app.`appointmentID` AND vp2.vitalID = 1
WHERE pd.type =$patientType
AND dfs.doctorID =$doctorID
GROUP BY app.`appointmentID` ";

$result = mysql_query($theQuery);


$indexLine = 3;
while ($row=mysql_fetch_array($result)){
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A$indexLine", $row['patientName'])
        ->setCellValue("B$indexLine", $row['age'])
        ->setCellValue("C$indexLine", $row['sex'])
        ->setCellValue("D$indexLine", $row['date'])
        ->setCellValue("E$indexLine", $row['bp'])
        ->setCellValue("F$indexLine", $row['pulse']);

    $nestedAppId = $row['appID'];

    //echo $nestedAppId;


    $nestedResult1 = mysql_query("SELECT  `entryDate`
                                FROM  `follow_up_result` fur
                                WHERE appID = $nestedAppId
                                GROUP BY entryDate");

    while ($nestedRow1=mysql_fetch_array($nestedResult1)){
        $entryDate = $nestedRow1['entryDate'];
        $nestedResult = mysql_query("SELECT  `resultID`, `appID`, `followUpID`, `data`, `entryDate`, i.name
                                FROM  `follow_up_result` fur
                                JOIN  `doctor_followup_setteing` dfs ON fur.`followUpID` = dfs.`followUpSerttingID`
                                JOIN `inv` i ON i.id = dfs.invID
                                WHERE appID = $nestedAppId AND entryDate = '$entryDate'");
        $indexLine++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($abc[6].$indexLine, "$entryDate");
        $fIndex = 7;
        while ($nestedRow=mysql_fetch_array($nestedResult)){
            //echo $abc[$fIndex].$indexLine;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($abc[$fIndex].$indexLine, $nestedRow['data']);
            $fIndex++;
        }

    }
    $indexLine++;


}


foreach(range('A',$num) as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}

$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);

//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:K1');

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->getDefaultStyle()->applyFromArray($style);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
