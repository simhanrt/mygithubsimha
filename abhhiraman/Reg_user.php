<?php

 include 'pragati.php';
 
 $Username = $_GET['User_Name'];
 $Mobileno = $_GET['User_Mob'];
 $Pubkey =md5(microtime().rand(1000, 9999));
 $Prikey = implode('-', str_split(substr(strtolower($Pubkey), 0, 32), 6)); 
 
 $checkUser = "select ApiKey from MobileUsers where MobileNO = $Mobileno;";
 
 $execheck = sqlsrv_query($pragaticonn,$checkUser);
  $row_count = sqlsrv_fetch_array( $execheck , SQLSRV_FETCH_ASSOC);  
  $count=$row_count['ApiKey'];
  if($count!="")
  {
	 $keyex = explode("-",$count);
	 $keyim=implode("",$keyex);
	 echo $keyim;
  }	  
  else
 {
 $Query1="Insert into MobileUsers(UseName, MobileNO, RegisterDate, ApiKey) values ('$Username', $Mobileno, CURRENT_TIMESTAMP, '$Prikey');";
 $exeQuery=sqlsrv_query($pragaticonn,$Query1);
 if($exeQuery)
 {
	 echo $Pubkey;
 }
 else
 {
	echo "fail"; 
 } 
 } 
?>