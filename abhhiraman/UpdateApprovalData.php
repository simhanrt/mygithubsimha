<?php
 include 'db.php';
 
 $PassbookNo=$_GET['PassbookNo'];
 $VentureId=$_GET['VentureId'];
 $Remarks=$_GET['Remarks'];
 $Activity=$_GET['Activity'];
 $ApiKey=$_GET['ApiKey'];
 $key=implode('-', str_split(substr(strtolower($ApiKey), 0, 32), 6));
 
if($Activity=="Plot")
{	
 $query="update Master.MemberApproval set PlotApproval='Y', PlotApprDate=CURRENT_TIMESTAMP,
 PlotStatusRemarks='$Remarks', ApiKey='$key'
 where Pbno='$PassbookNo' and VentureCd='$VentureId'";
}
else if($Activity=="Cost")
{
 $query="update Master.MemberApproval set PlotCostApproval='Y', PlotCostApprDate=CURRENT_TIMESTAMP,
 PlotCostRemarks='$Remarks', ApiKey='$key'
 where Pbno='$PassbookNo' and VentureCd='$VentureId'";
}else if($Activity=="Discount")
{
 $query="update Master.MemberApproval set DiscountApproval='Y', DiscountApprDate=CURRENT_TIMESTAMP,
 DiscountRemarks='$Remarks', ApiKey='$key'
 where Pbno='$PassbookNo' and VentureCd='$VentureId'";
}else
{
 $query="update Master.MemberApproval set CommissionApproval='Y', CommissionApprDate=CURRENT_TIMESTAMP,
 CommissionRemarks='$Remarks', ApiKey='$key'
 where Pbno='$PassbookNo' and VentureCd='$VentureId'";
}
 
 $exequery=sqlsrv_query($conn,$query);
  if($exequery)
  {
	  echo "Success";
  }
  else
  {
	  echo "Fail";
  }
?>