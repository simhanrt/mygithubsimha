<?php
 include 'db.php';
 
 $VentureCd=$_GET['VentureCd'];
 
 $selectQuery="select m.MemberId,m.ApplicantName,m.DateJoin,p.PlotApproval, p.PlotCostApproval,p.CommissionApproval,p.DiscountApproval
  from master.Member as m
 left join
 master.MemberApproval as p on
 p.Pbno = m.MemberId 
 and
 p.VentureCd = m.VentureCd
 where 
 m.VentureCd='$VentureCd' and  PlotApproval='Y' and PlotCostApproval='Y' and DiscountApproval='Y' 
 and CommissionApproval='Y';";
 $exeQuery=sqlsrv_query($conn,$selectQuery);
 while($rowdata=sqlsrv_fetch_object($exeQuery))
 {
	 $data[]=$rowdata;
 }
 echo json_encode($data);
?>