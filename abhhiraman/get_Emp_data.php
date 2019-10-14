<?php
 include "Sanddb.php";
 
 $EmpId=$_GET['EmpId'];
 
 $query="select USERNAME,MOBILE from dbo.USERS where USERID='$EmpId';";
 $exequery=sqlsrv_query($sandconn,$query);
 $values=sqlsrv_fetch_array($exequery,SQLSRV_FETCH_ASSOC);
 $empName=$values['USERNAME'];
 $empMobile=$values['MOBILE'];
 if($empName=="")
 {
	 echo "not_employee";
 }
 else if($empMobile=="")
 {
	 echo "no_number";
 }
 else
 {
 echo $empName.','.$empMobile;
 }
?>