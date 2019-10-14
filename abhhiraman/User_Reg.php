<?php
 include 'mobiledb.php';
 
 $UserName = $_GET['User_Name'];
 $MobileNO = $_GET['User_Mob'];
 $CompanyId= $_GET['Company_Id'];
 $curdate = (String)Date('Y-m-d');
 $Pubkey =md5(microtime().rand(1000, 9999));
 $Prikey = implode('-', str_split(substr(strtolower($Pubkey), 0, 32), 6));
 
 $checkUser = "select * from master.MobileUser where Mobile =$MobileNO and Cid='$CompanyId';";
 $execheck = sqlsrv_query($mobconn,$checkUser);
 $row_count = sqlsrv_num_rows($execheck);
 if(sqlsrv_num_rows($execheck)>0)
 {
	echo "existing_User"; 
 }
 else
 {
 $Query="Insert into master.MobileUser(Name, Mobile, Cid, ApiKey, RegisterDate) values ('$UserName', $MobileNO, '$CompanyId', '$Prikey', '$curdate');";
 $exeQuery=sqlsrv_query($mobconn,$Query);
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