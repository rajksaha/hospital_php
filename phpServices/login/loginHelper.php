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
                $_SESSION['doctorID'] = $rec['doctorID'];

                $_SESSION['userType'] = $userType;

                if($userType != 'DOCTOR'){
                    $sql = "SELECT aa.`accessID`, aa.`accessCode`, aa.`accessDesc`, aa.`accessType`, aa.`parentAccessID`, ua.`userAccessId` 
						FROM `app_access` aa 
						JOIN user_access ua ON ua.`accessID` = aa.`accessID`
						WHERE ua.`userID` =  $user_id";
                    while ($row=mysql_fetch_array($sql)){
                        array_push($data,$row);
                    }
                    $_SESSION['userAccess'] = json_encode($data);
				}
				echo 1;
			}else{
                echo 0;
			}
		}
      	

      
      
?>
