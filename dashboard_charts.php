<?php 

include "config/load.php";

if(isset($_POST['Action']) && $_POST['Action'] === "donut"){
    	$sqlItemType = "SELECT COUNT(*) AS Totals, p.ItemName FROM products as p INNER JOIN itemtype as i ON i.ID = p.ItemType GROUP BY ItemType";

		$query1 = mysqli_query($conn, $sqlItemType);

        $dataList = array();

		if($query1){
			if(mysqli_num_rows($query1) > 0){
				while($row = mysqli_fetch_array($query1)){
                    $dataList[] = array(
                        "Totals" => $row['Totals'],
                        "Description" => $row['ItemName'],
                    );
				}

			}
		}

        echo json_encode($dataList);
}

elseif(isset($_POST['Action']) && $_POST['Action'] === "bar"){
    $sqlItemType = "SELECT 
  DATE_FORMAT(`TimeStamp`, '%M') AS MonthName,
  SUM(`AmountPaid`) AS MonthlySum
FROM paymentstrail
WHERE IFNULL(isCancelled, '') <> '1'
GROUP BY DATE_FORMAT(`TimeStamp`, '%Y-%m')";

		$query1 = mysqli_query($conn, $sqlItemType);

        $dataList = array();

		if($query1){
			if(mysqli_num_rows($query1) > 0){
				while($row = mysqli_fetch_array($query1)){
                    $dataList[] = array(
                        "Totals" => $row['MonthlySum'],
                        "Description" => $row['MonthName'],
                    );
				}

			}
		}

        echo json_encode($dataList);

}









?>