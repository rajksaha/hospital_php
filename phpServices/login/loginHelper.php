<?php
include('../config.inc');
session_start();
     $username=mysql_real_escape_String($_POST['username']);
     $password=mysql_real_escape_String($_POST['password']);
     
$sql=mysql_query("SELECT * FROM `user_profile` WHERE `username` ='$username'");
      $rec=  mysql_fetch_array($sql);
		if($rec == ""){
			echo -1;
		}else{
			if(($rec['isActive']==$username)){
				echo -2;
			}else if($rec['password']==$password){
				$userId = $rec['userID'];
                $userType = $rec['userType'];
                $_SESSION['username'] = $username;
                $_SESSION['userID'] = $userId;
                $doctorID = $rec['doctorID'];
                $_SESSION['doctorID'] = $doctorID;
                $_SESSION['userType'] = $userType;
                $data = mysql_query("SELECT `doctorID`, `lastBackupDate` FROM `doctor_data_backup` WHERE doctorID = $doctorID");
				if($data){
                    $backUp = mysql_fetch_assoc($data);
                    $backUPDate = $backUp['lastBackupDate'];
                    if((time()-(60*60*24*7)) > strtotime($backUPDate)){
                        backUpData($doctorID);
                    }else{
                    }
				}
				echo 1;
			}else{
                echo 0;
			}
		}


      	
function backUpData($doctorID){
    $tables = array();

    $con = mysqli_connect('localhost', 'root', 'pass', 'arefin_db');

    $result = mysqli_query($con, "SHOW TABLES");
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }

    $return = '';
    foreach ($tables as $table) {
        $result = mysqli_query($con, "SELECT * FROM " . $table);
        $num_fields = mysqli_num_fields($result);

        $return .= 'DROP TABLE ' . $table . ';';
        $row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE ' . $table));
        $return .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $return .= 'INSERT INTO ' . $table . 'VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < $num_fields - 1) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
        }
        $return .= "\n\n\n";

    }


    $handle = fopen('D:backup/doctorPlatform.sql', 'w+');
    fwrite($handle, $return);
    fclose($handle);
    $now = date('Y-m-d');;
    mysql_query("UPDATE `doctor_data_backup` SET `lastBackupDate`= '$now' WHERE `doctorID` = $doctorID");
}
      
      
?>

