<?php
  include 'sanddb.php';
  
  //$ApiKey=$_GET['Api_Key'];
  $ventureCd = $_GET['Venture'];
  $status = $_GET['Status'];
  $Sector = $_GET['Sector'];
  $data=array();
  
  $query="select count(PlotNo) as total,sum(PLOTAREA) as extend,FACING from master.PlotMaster
   where VentureCd='$ventureCd' and Status='$status' and SectorCd='$Sector' Group by FACING;";
  $exequery=sqlsrv_query($sandconn,$query);
  while($row=sqlsrv_fetch_object($exequery))
  {
	  $data[]=$row;
  }
  echo json_encode($data);
  
?>