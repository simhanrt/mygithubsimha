<?php
  include 'sanddb.php';
  
  //$ApiKey=$_GET['Api_Key'];
  $ventureCd = $_GET['Venture'];
  $status = $_GET['Status'];
  $Facing = $_GET['Facing'];
  $Sector = $_GET['Sector'];
  
  $query="select PlotNo,PLOTAREA from master.PlotMaster where VentureCd='$ventureCd' and Status='$status'
   and FACING='$Facing' and SectorCd='$Sector' order by VentureCd,SectorCd,CASE WHEN PATINDEX('%[a-zA-Z/,&-]%',PlotNo) > 0 then cast(left(PlotNo,(PATINDEX('%[a-zA-Z/,&-]%',PlotNo)-1)) as int) else cast(PlotNo as int) end,PlotNo;";
  $exequery=sqlsrv_query($sandconn,$query);
  while($row=sqlsrv_fetch_object($exequery))
  {
	  $data[]=$row;
  }
  echo json_encode($data);
  
?>