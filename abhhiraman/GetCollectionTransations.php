<?php
	include 'db.php';
	
	$venture = $_GET['venture'];
	$acctype = $_GET['acctype'];
	$Date = $_GET['date'];
	$data=array();
	if($Date=='now')
    $curr_timestamp = date('d-m-Y');
    else
    $curr_timestamp = $Date;
	if($acctype==10000)
	{
	$query=" set dateformat dmy
    select BookType,MemberReceiptsId,CheqDDno,convert(varchar,CheqDate,103) as
	 cheqdate,BankName,convert(varchar,ReceiptdDate,103) as receiptDate,
	 convert(varchar,CreatedOn,103) as PostingDate,PassBook,ApplName,RecAmount,Discount 
    from master.TempRecData where VentureCd='$venture' and
	 cast(CreatedOn as date)='$curr_timestamp' and BookType='GEN2';";	
	}
	else
	{
	$query="set dateformat dmy
    select BookType,MemberReceiptsId,CheqDDno,convert(varchar,CheqDate,103) as cheqdate,BankName,convert(varchar,ReceiptdDate,103) as receiptDate,convert(varchar,CreatedOn,103) as PostingDate,PassBook,ApplName,RecAmount,Discount 
    from master.MemberReceipts where VentureCd='$venture' and cast(CreatedOn as date)='$curr_timestamp' and Acnumb = '$acctype';";			
	}	
	$exequery=sqlsrv_query($conn,$query);
	while($row=sqlsrv_fetch_object($exequery))
	{
		$data[]=$row;
	}
	echo json_encode($data);
?>