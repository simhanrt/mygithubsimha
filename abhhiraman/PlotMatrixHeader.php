<?php
 include 'sanddb.php';
 
 //$ApiKey=$_GET['ApiKey'];
 
 $venture_query="select count(PlotNo) as Total,sum(PLOTAREA) as Extend,Status,VentureCd,SectorCd from master.PlotMaster 
  group by VentureCd,Status,SectorCd order by VentureCd,SectorCd;";
 $exequery=sqlsrv_query($sandconn,$venture_query);
 while($row=sqlsrv_fetch_object($exequery))
 {
   $data[]=$row;
 }
 echo json_encode($data);
?>