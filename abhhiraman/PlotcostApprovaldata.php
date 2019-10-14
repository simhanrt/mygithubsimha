<?php
 include 'db.php';
 
 $PassbookNo=$_GET['PassbookNo'];
 $VentureId=$_GET['VentureId'];
 
 $query="select  m.Memberid,m.SectorCd,m.PlotNo,m.PlotArea,p.PCATEG ,p.FACING,m.RatePerSq,m.AdminFee,m.TotalCost,m.DevCharges,m.Premium as costPremium,m.BSP4,m.bsp6,m.Others,
m.CarpusFund,m.CompDiscount,m.Discount,f.Rate_Calc,c.RateNumber as spPremium,f.RateNumber as Premium from master.Member as m 
  left join master.plotmaster as p 
  on 
  p.VentureCd =m.VentureCd and m.plotno =p.PlotNo 
  AND M.SECTORCD =P.SectorCd LEFT JOIN MASTER.Facing_Rate_Master AS f on f.Vencode = p.VentureCd and f.face = p.FACING  
  left join master.Plot_Category_Master aS c on c.VenCode =p.VentureCd and c.Category_Name =p.PCATEG 
  WHERE m.MemberId ='$PassbookNo' and m.venturecd ='$VentureId';";
 $exequery=sqlsrv_query($conn,$query);
  while($rowdata=sqlsrv_fetch_object($exequery))
  {
	  $rowdata->PaidAmount = getPaidAmount($VentureId,$PassbookNo);
	  if (is_null($rowdata->spPremium)){
	    $rowdata->spPremium = 0;
	  }
	  $data[]=$rowdata;
  }
  function getPaidAmount($Venture,$passbook) 
 {
	 $pay = 0.0;
	 $pay += getMemberRec($Venture,$passbook); 
	 $pay -= getMemberPay($Venture,$passbook);
	 return $pay;
 }
 
 function getMemberRec($venture,$passbook) 
 {
	 include 'db.php';
	 $payment=0.0;
	 $query1="select sum(recamount) as recamount from master.memberreceipts where venturecd='$venture' and passbook='$passbook' and recmode!='MAINTENANCE' and recmode!='Registration';";	
	 $query2="select sum(recamount) as tempamount from master.temprecdata where venturecd='$venture' and passbook='$passbook' AND recmode!='MAINTENANCE' and recmode!='Registration';";
	 $query3="select  sum(amount) as agentamount from master.agenttomemberjv where venturecd2='$venture' and Passbook='$passbook'  AND TransactionType!='MAINTENANCE' and TransactionType!='Registration';";
	 $query4="select sum(amount) as mamberamount from master.memberpayment where venturecd='$venture' and passbook='$passbook' and brsstatus='B'  AND RECMODE!='MAINTENANCE' and RecMode='Registration';";
	 $query5="select  sum(amount) as jvamount from master.memberjv where VentureCd='$venture' and Pbno='$passbook'  AND TransactionType!='MAINTENANCE' and TransactionType!='Registration';";
	 
	 $exeQuery=sqlsrv_query($conn,$query1);
	 $row=sqlsrv_fetch_array($exeQuery,SQLSRV_FETCH_ASSOC);
	 $payment+=$row['recamount'];
	 
	 $exeQuery1=sqlsrv_query($conn,$query2);
	 $row1=sqlsrv_fetch_array($exeQuery1,SQLSRV_FETCH_ASSOC);
	 $payment+=$row1['tempamount'];
	 
	 $exeQuery2=sqlsrv_query($conn,$query3);
	 $row2=sqlsrv_fetch_array($exeQuery2,SQLSRV_FETCH_ASSOC);
	 $payment+=$row2['agentamount'];
	 
	 $exeQuery3=sqlsrv_query($conn,$query4);
	 $row3=sqlsrv_fetch_array($exeQuery3,SQLSRV_FETCH_ASSOC);
	 $payment+=$row3['mamberamount'];
	 
	 $exeQuery4=sqlsrv_query($conn,$query5);
	 $row4=sqlsrv_fetch_array($exeQuery4,SQLSRV_FETCH_ASSOC);
	 $payment+=$row4['jvamount'];
	
	 return $payment;
 }
 function getMemberPay($venture,$passbook) 
 {
	 include 'db.php';
	 $BRS=0.0;
	 $query1="select sum(amount) as pay_amount from master.memberpayment where venturecd='$venture' and passbook='$passbook' and (brsstatus='C' or brsstatus is null) AND RECMODE!='MAINTENANCE' and RecMode!='Registration';";	
     $query2="select sum(recamount) as rec_amount from master.memberreceipts where venturecd='$venture' and passbook='$passbook' and (brsstatus='B')  AND RECMODE!='MAINTENANCE' and RecMode!='Registration';";
	 $query3="select sum(amount) as agent_amount from master.membertoagentjv where venturecd1='$venture' and Passbook='$passbook'  AND TransactionType!='MAINTENANCE' and TransactionType!='Registration';";
	 $query4="select  sum(amount) as jv_amount from master.memberjv where venturecd='$venture' and pbno='$passbook'  AND TransactionType!='MAINTENANCE' and TransactionType!='Registration';";
	 
	 $exeQuery=sqlsrv_query($conn,$query1);
	 $row=sqlsrv_fetch_array($exeQuery,SQLSRV_FETCH_ASSOC);
	 $BRS+=$row['pay_amount'];
	 
	 $exeQuery1=sqlsrv_query($conn,$query2);
	 $row1=sqlsrv_fetch_array($exeQuery1,SQLSRV_FETCH_ASSOC);
	 $BRS+=$row1['rec_amount'];
	 
	 $exeQuery2=sqlsrv_query($conn,$query3);
	 $row2=sqlsrv_fetch_array($exeQuery2,SQLSRV_FETCH_ASSOC);
	 $BRS+=$row2['agent_amount'];
	 
	 $exeQuery3=sqlsrv_query($conn,$query4);
	 $row3=sqlsrv_fetch_array($exeQuery3,SQLSRV_FETCH_ASSOC);
	 $BRS+=$row3['jv_amount'];
	
	 return $BRS;
 }
  echo json_encode($data);
?>