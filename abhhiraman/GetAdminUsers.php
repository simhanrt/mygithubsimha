<?php
 //Created By Janakiramayya on 02-08-2018
 include 'Sanddb.php';
 
 $query="Select USERID,USERNAME,BRANCHCD,MOBILE,MobileRegDate,isAdmin FROM DBO.USERS where ISACTIVE=1 and USERID!=00;";
 $exequery=sqlsrv_query($sandconn,$query);
 while($row=sqlsrv_fetch_object($exequery))
 {
	$data[]=$row; 
 }
 echo json_encode($data);
 
 
 
?>