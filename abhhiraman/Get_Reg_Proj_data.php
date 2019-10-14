<?php
include "Sanddb.php";

$data=array();

$q=sqlsrv_query($sandconn,"select VentureCd,VentureName from master.Venture as V;");
while ($row=sqlsrv_fetch_object($q)){
 $VentureCd=$row->VentureCd;
 
 $getAvlCount="select distinct[SectorCd] from master.PlotMaster as p where VentureCd='$VentureCd'";
 $exeAvlcount_que=sqlsrv_query($sandconn,$getAvlCount);
 $Sector='';
 while ($row1=sqlsrv_fetch_object($exeAvlcount_que)){
    $Sector.=$row1->SectorCd.',';
 }
 if($Sector!='')
 {
 $row->Sector=$Sector;
 $data[]=$row;
 }
 
}
print_r(json_encode($data));
?>