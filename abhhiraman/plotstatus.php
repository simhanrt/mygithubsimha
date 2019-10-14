<?php
  session_start();
  include 'Sanddb.php';
  $VentureId = $_GET['VentureId'];
  $SectorId = $_GET['SectorId'];
  $PlotNo = $_GET['PlotNo'];
  $curdate = (String)Date('d-m-y');
  $_SESSION['Id'] = $_GET['Id'];
  
  
  $selectquer="select Status from Master.PlotMaster where PlotNo='$PlotNo' and VentureCd='$VentureId' and SectorCd='$SectorId';";
  $exeselect=sqlsrv_query($sandconn,$selectquer);
  $Status = sqlsrv_fetch_array($exeselect,SQLSRV_FETCH_ASSOC);
  $pStatus = $Status['Status'];
  sqlsrv_free_stmt($exeselect);
  echo $pStatus;
  
?>