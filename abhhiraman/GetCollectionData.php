<?php
 include 'db.php';
 
 $ApiKey=$_GET['ApiKey'];
 $Prikey = implode('-', str_split(substr(strtolower($ApiKey), 0, 32), 6));
 $data=array();
 $curr_timestamp = date('d-m-Y');
 
 $superquery="select USERTYPE from dbo.USERS where Apikey='$Prikey';";
 $superexe=sqlsrv_query($conn,$superquery);
 $values=sqlsrv_fetch_array($superexe,SQLSRV_FETCH_ASSOC);
 $superAdmin=$values['USERTYPE'];
 if($superAdmin=='A')
 {
 $query="set dateformat dmy  select SUM(recamount) as RecAmount,Acnumb ,m.venturecd ,v.VentureName 
 from master.MemberReceipts as m left join master.Venture as v
 on  m.venturecd=v.venturecd where cast(m.CreatedOn   as date)= '$curr_timestamp' 
 and (Acnumb between 300 and 499 or Acnumb = 1000) and RecMode not
 in ('REGISTRATION','MAINTENNACE','TReANSFERFEE') group by 
 Acnumb,m.venturecd,VentureName  order by m.venturecd;";
 $exequery=sqlsrv_query($conn,$query);
 while ($row=sqlsrv_fetch_object($exequery)){
 $data[]=$row; 
 } 
 $payments="set dateformat DMY select SUM(AMOUNT) as PaymentTotal from master.LedgerMaster where PaymentDate='$curr_timestamp' and AmtType='D' AND AccType IN ('APY','MPY') AND (Vcode BETWEEN 300 And 400 OR VCode=1000);";
 $exepayments=sqlsrv_query($conn,$payments);
 while ($row=sqlsrv_fetch_object($exepayments)){
 $data[]=$row; 
 }
 }
 else
 {
	 $row = array('USERTYPE' => 'R');
	 $data[]=$row;
 }
 
 echo json_encode($data); 
 
?>