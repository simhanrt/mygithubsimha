<?php
 include 'db.php';
 
 $date = $_GET['date'];
 $venture = $_GET['VentureCd'];
 $userType = $_GET['AccType'];
 $data=array();
 if($date=='now')
 $curr_timestamp = date('d-m-Y');
 else
 $curr_timestamp = $date;	 
 
 $query = "set dateformat dmy
 select Vouchno,Vcode,convert(varchar,PaymentDate,103) as PaymentDate,AgentCode,m.AgentName,Amount,CheqDDno,convert(varchar,CheqDate,103) as CheqDate from 
 master.LedgerMaster as l left join master.AgentMaster as m on l.AgentCode=m.AgentMasterCd 
 where cast(PaymentDate as date)='$curr_timestamp' and AmtType='D' AND AccType IN ('$userType') AND 
 (Vcode BETWEEN 300 And 400 OR VCode=1000) and VentureCd='$venture';";
 if($userType=='APY')
 {
	 $query1="set dateformat dmy
 select AgentPaymentId as Vouchno,convert(varchar,ReceiptdDate,103) as PaymentDate,AgenCode as AgentCode,m.AgentName,Amount,CheqDDno,CONVERT(varchar,CheqDate,103) as CheqDate
  from master.TempApyData as l left join master.AgentMaster as m on l.AgenCode=m.AgentMasterCd
  where cast(l.CreatedOn as date)='$curr_timestamp' AND VentureCd='$venture';";
  $exequery1 = sqlsrv_query($conn,$query1);
  while($row1=sqlsrv_fetch_object($exequery1))
  {
	$row1->Vcode='10000';
	$data[]=$row1;
  }
 }
 else if($userType=='MPY')
 {
	 $query1=" set dateformat dmy select MemberPaymentId as Vouchno,convert(varchar,l.CreatedOn,103) as PaymentDate,PassBook as AgentCode,m.ApplicantName as AgentName,Amount,CheqDDno,CONVERT(varchar,CheqDate,103) as CheqDate
  from master.TempMpyData as l left join master.Member as m on l.PassBook=m.MemberId and l.VentureCd=m.VentureCd
  where cast(l.CreatedOn as date)='$curr_timestamp' AND l.VentureCd='$venture';";
  $exequery1 = sqlsrv_query($conn,$query1);
  while($row1=sqlsrv_fetch_object($exequery1))
  {
	$row1->Vcode='10000';
	$data[]=$row1;
  } 
 }
 else if($userType=='PAY')
 {
	$query1="set dateformat dmy select PaymentVoucherId as Vouchno,convert(varchar,l.CreatedOn,103) as 
  PaymentDate,PartyCd as AgentCode,Party as AgentName,Amount
  from master.TempPayment as l left join master.MastAcc on PartyCd=Code 
   where cast(l.CreatedOn as date)='$curr_timestamp' AND
   l.VentureCd='$venture'";
  $exequery1 = sqlsrv_query($conn,$query1);
  while($row1=sqlsrv_fetch_object($exequery1))
  {
	$row1->Vcode='10000';
	$row1->CheqDDno='';
	$row1->CheqDate='';
	$data[]=$row1;
  }  
 }
 
 $exequery = sqlsrv_query($conn,$query);
 while($row=sqlsrv_fetch_object($exequery))
 {
	$data[]=$row;
 }
 echo json_encode($data);
?>