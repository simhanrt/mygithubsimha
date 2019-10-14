<?php
 include 'db.php';
 $data=array();
 $selquery = "select count(p.Pbno) as count, p.VentureCd, v.VentureName, v.UnitCd, v.Plot,v.CommCalc  from Master.MemberApproval as p left join master.venture as v on v.venturecd = p.venturecd where not p.PlotApproval='Y' or not 
p.PlotCostApproval='Y' or not p.DiscountApproval='Y' or not p.CommissionApproval='Y' 
group by p.VentureCd ,v.venturename,v.Plot,v.UnitCd,v.CommCalc;";
 $res = sqlsrv_query($conn, $selquery);
 while($rowdata = sqlsrv_fetch_object($res))
 {
	 $data[]=$rowdata;
 }
 echo json_encode($data);
 
?>