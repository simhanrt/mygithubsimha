<?php
  include 'db.php';
  
  //$ApiKey=$_GET['Api_Key'];
  $ventureCd = $_GET['Venture'];
  $status = $_GET['Status'];
  $plotno = $_GET['PlotNo'];
  $Sector = $_GET['Sector'];
  
  $query=" select a.Pbno,m.ApplicantName,m.DateJoin,a.PlotApproval,a.PlotCostApproval,a.DiscountApproval,a.CommissionApproval
  from master.member as m
  left join master.memberApproval as a on m.MemberId=a.Pbno and m.VentureCd=a.VentureCd 
  where PlotNo='$plotno' and m.VentureCd='$ventureCd' and
  SectorCd='$Sector';";
  $exequery=sqlsrv_query($conn,$query);
  while($row=sqlsrv_fetch_object($exequery))
  {
	  $data[]=$row;
  }
  echo json_encode($data);
  
?>