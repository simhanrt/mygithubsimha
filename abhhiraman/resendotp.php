<?php
//Created By Janakiramayya on 01-08-2018
 include 'Sanddb.php';
 require('textlocal.class.php');
 
 $Id=$_GET['Id'];
 $Otp=$_GET['Otp'];
 $textlocal = new Textlocal('info@siyoradevelopers.com', 'Welcome@123');
 $sender = 'Siyora';
 $key=implode('-', str_split(substr(strtolower($Id), 0, 32), 6));
 $message=urlencode("5-Digit Otp Pin is: ".$Otp);
 
 $stmt="select MOBILE from dbo.users where ApiKey='$key';";
 $exeStmt=sqlsrv_query($sandconn,$stmt);
 $values=sqlsrv_fetch_array($exeStmt,SQLSRV_FETCH_ASSOC);
 $Empmob=$values['MOBILE'];
 $number=array($Empmob);
   // $result = $textlocal->sendSms($number, $message, $sender);
 echo "success";
?>