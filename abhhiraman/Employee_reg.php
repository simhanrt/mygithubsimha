<?php
 //Created By Janakiramayya on 20-07-2018
 include 'Sanddb.php';
 
 $Emp_no = $_GET['Emp_No'];
 $Emp_Name = $_GET['Emp_Name'];
 $Emp_Mob = $_GET['Emp_Mob'];
 $Pubkey =md5(microtime().rand(1000, 9999));
 $Prikey = implode('-', str_split(substr(strtolower($Pubkey), 0, 32), 6));
 $pinNo=rand(11111,99999);
 $curr_timestamp = date('Y-m-d H:i:s');
 $message=urlencode("5-Digit Otp Pin is: ".$pinNo);
 $number=array($Emp_Mob);
 $CheckEmp="select USERID from dbo.USERS WHERE USERID = '$Emp_no' and Mobile = '$Emp_Mob' and ISACTIVE=1;";
 $exeStmt=sqlsrv_query($sandconn,$CheckEmp);
 $values=sqlsrv_fetch_array($exeStmt,SQLSRV_FETCH_ASSOC);
 $EmpId=$values['USERID'];
 if($EmpId>0)
 {
	 $checkRegMob="select ApiKey from dbo.USERS Where USERID='$EmpId';";
	 $exeCheckReg=sqlsrv_query($sandconn,$checkRegMob);
	 $row_count = sqlsrv_fetch_array( $exeCheckReg , SQLSRV_FETCH_ASSOC);  
     $count=$row_count['ApiKey'];
	 if($count!="")
	 {
     $curl_handle=curl_init();
     curl_setopt($curl_handle, CURLOPT_URL,'http://smsstreet.in/websms/sendsms.aspx/?userid=raghavender&password=R@9494rr&sender=ABIRMN&mobileno='.$Emp_Mob.'&msg='.$message);
     curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($curl_handle, CURLOPT_USERAGENT, 'reportapp');
     $query = curl_exec($curl_handle);
     curl_close($curl_handle);
	 
	 $keyex = explode("-",$count);
	 $keyim=implode("",$keyex);
	 echo $keyim.",".$pinNo;
	 }
	 else
	 { 
	 $updateque="update dbo.USERS set ApiKey='$Prikey',MobileRegDate=CURRENT_TIMESTAMP where USERID='$EmpId';";
	 $exeupdate=sqlsrv_query($sandconn,$updateque);
	 if($exeupdate)
	 {
		$curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,'http://smsstreet.in/websms/sendsms.aspx/?userid=raghavender&password=R@9494rr&sender=ABIRMN&mobileno='.$Emp_Mob.'&msg='.$message);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'reportapp');
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
		 echo $Pubkey.",".$pinNo;
	 }
	 else
	 {
		echo "fail";
	 }
  }
 }
 else
 {
	echo "not_employee"; 
 }
?>