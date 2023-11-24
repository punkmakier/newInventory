<?php
/**
 * 
 */
class Transactions 
{
	
	function __construct()
	{
		// code...
	}

	public function getTotalTransactions()
	{
		$sql = safe_query("SELECT a.ORNo from paymentstrail a 
			LEFT JOIN products p ON p.ID = a.ItemCode 
			LEFT JOIN transactions t ON t.ItemCode=p.ItemCode AND t.Action='1'
			WHERE IFNULL(isCancelled,'')<>'1' AND t.ItemCode IS NULL GROUP BY a.ORNo");
		return mysqli_num_rows($sql);
	}
	public function getTotalTransactionsPerMonth($month)
	{
		$curMonth = $month;
		$nxtMonth = $month+1;
		$sql = safe_query("SELECT SUM(AmountPaid) AS AmountPaid from paymentstrail a 
			LEFT JOIN products p ON p.ID = a.ItemCode 
			LEFT JOIN transactions t ON t.ItemCode=p.ItemCode AND t.Action='1' 
			WHERE a.TimeStamp BETWEEN '".date('Y')."-{$curMonth}-01 00:00:00' AND '".date('Y')."-{$nxtMonth}-01 00:00:00' AND IFNULL(isCancelled,'')<>'1' AND t.ItemCode IS NULL GROUP BY ORNo");
		$rw=mysqli_fetch_assoc($sql);
		return ($rw['AmountPaid'] ? $rw['AmountPaid'] : 0);
	}


	public function getTotalSales()
	{
		$sql = safe_query("SELECT SUM(`AmountPaid`) AS Total FROM paymentstrail WHERE IFNULL(isCancelled, '') <> '1'");
		$rw=mysqli_fetch_assoc($sql);
		return $rw['Total'];
	}

	public function getTotalTransactionThisMonth()
	{
		$sql = safe_query("SELECT COUNT(*) AS Total
FROM paymentstrail
WHERE IFNULL(isCancelled, '') <> '1'
AND YEAR(`TimeStamp`) = YEAR(CURDATE())
AND MONTH(`TimeStamp`) = MONTH(CURDATE());");
		$rw=mysqli_fetch_assoc($sql);
		return $rw['Total'];
	}







}

$transactions = new Transactions();