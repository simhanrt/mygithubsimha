<?php
 include 'Sanddb.php';

 $Id = $_GET['Id'];
 $pin = $_GET['Pin'];
 $key=implode('-', str_split(substr(strtolower($Id), 0, 32), 6));

 $updatequery="update dbo.USERS set MobPin=$pin where ApiKey='$key' and isAdmin=1;";
 $exequery=sqlsrv_query($sandconn,$updatequery);
 if($exequery)
 {
	 echo "success";
 }
 else
 {
	 echo "fail";
 }
 ?>