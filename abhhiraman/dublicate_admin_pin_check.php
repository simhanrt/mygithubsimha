<?php
 session_start();
 include 'Sanddb.php';

 $Id = $_GET['Id'];
 $pin = $_GET['Pin'];
 $key=implode('-', str_split(substr(strtolower($Id), 0, 32), 6));

 
 
 $query="select USERID,MobPin from dbo.USERS where ApiKey='$key' and ISACTIVE=1 and isAdmin=1;";
 $exequery=sqlsrv_query($sandconn,$query);
 $Status = sqlsrv_fetch_array($exequery,SQLSRV_FETCH_ASSOC);
 $EmpNo = $Status['USERID'];
 $pStatus = $Status['MobPin'];
 if($EmpNo=="")
 {
	 echo "Not_Admin";
 }
 else if($EmpNo==00)
 {
	 if($pStatus==$pin)
	 {
		 echo "SuperSuccess";
	 }
	 else
	 {
		 echo "miss_match";
	 }
 }else
 {
	if($pStatus==$pin)
	 {
		 echo "Success";
	 }
	 else
	 {
		 echo "miss_match";
	 } 
 }
?>