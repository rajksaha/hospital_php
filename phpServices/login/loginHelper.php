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
				echo 1;
			}else{
                echo 0;
			}
		}
      	

      
      
?>
