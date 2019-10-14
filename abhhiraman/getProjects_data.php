<?php
include "db.php";
include "mobiledb.php";
 $CompanyId=$_GET['CompanyId'];
$data=array();
$q=sqlsrv_query($mobconn,"select PjctId as VENTUREID,Link as LINK, ImageLink as IMAGE,Sector as SECTORS,Title as TITLE, EnqyLink, longitude, latitude from Master.ProjectsData where Cid='$CompanyId' and Status=1 ORDER BY PjctNo DESC;");
while ($row=sqlsrv_fetch_object($q)){
 $VentureCd=$row->VENTUREID;
 $getTotCount="select count(PlotNo) as TotCount from master.PlotMaster where VentureCd='$VentureCd';";
 $execount_que=sqlsrv_query($conn,$getTotCount);
 $row_count = sqlsrv_fetch_array( $execount_que , SQLSRV_FETCH_ASSOC);  
 $count=$row_count['TotCount'];
 
 $getAvlCount="select count(PlotNo) as TotCount from master.PlotMaster where VentureCd='$VentureCd' and Status='N';";
 $exeAvlcount_que=sqlsrv_query($conn,$getAvlCount);
 $avl_count = sqlsrv_fetch_array( $exeAvlcount_que , SQLSRV_FETCH_ASSOC);  
 $avlcount=$avl_count['TotCount'];
 
 $row->totcount=$count;
 $row->avlcount=$avlcount;
 $data[]=$row;
 
}
print_r(json_encode($data));
?>