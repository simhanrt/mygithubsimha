<?php
 include 'mobiledb.php';
 
 $CompanyId = $_GET['CompanyId'];
 $data=array();
 
 $querynotice="select top(1) n.Title, n.Context from dbo.NoticeBoard n where n.Cid='$CompanyId' order by n.Sno DESC;";
 $exequerynotice=sqlsrv_query($mobconn,$querynotice);
 $values=sqlsrv_fetch_array($exequerynotice,SQLSRV_FETCH_ASSOC);
 $title=$values['Title'];
 $context=$values['Context'];
 $selectquery="select UpcomingProject,projectTitle,PjctId from dbo.UpcomingProjects where Cid='$CompanyId' order by No DESC;";

 $exequery=sqlsrv_query($mobconn,$selectquery);
 while($row=sqlsrv_fetch_object($exequery))
 {
	 $ProjectCd=$row->PjctId;
	 $row->Title=$title;
	 $row->Context=$context;
	 if($ProjectCd==null)
	 {
	 $row->LINK=null;
	 $row->SECTOR=null;
	 $row->EnqyLink=null;	 
	 }	 
	 else
	 {
	 $query="select PjctId as VENTUREID,Link as LINK,Sector as SECTORS, EnqyLink from 
	 Master.ProjectsData where Cid='$CompanyId' and Status=1 and 
	 PjctId='$ProjectCd';";
	 $queryobj=sqlsrv_query($mobconn,$query);
	 while($row1=sqlsrv_fetch_object($queryobj))
	 {
	 $row->LINK=$row1->LINK;
	 $row->SECTOR=$row1->SECTORS;
	 $row->EnqyLink=$row1->EnqyLink;
	 }
	 }
	 $data[]=$row;
	 
 }
 sqlsrv_free_stmt($exequery);
 echo json_encode($data); 
?>