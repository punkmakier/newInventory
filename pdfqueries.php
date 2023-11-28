<?php 

function dbconnect($server = 'localhost',$user='root',$pass='',$database='inventory'){
	$myLink = mysqli_connect($server,$user,$pass,$database);
	if(!$myLink){
		echo mysqli_connect_errno();
	}else{
		// echo "Connected!";
	}
	return $myLink;
}



function sold(){
    $conn = dbconnect();
    $sql = "SELECT a.AmountPaid,a.TimeStamp,b.ItemCode,b.Description, 'Sold' as label,a.Discount FROM paymentstrail a LEFT JOIN products b ON b.ID = a.ItemCode WHERE IFNULL(isCancelled,'') <> '1' AND TimeStamp";

    $query = mysqli_query($conn, $sql);

    $html = "";
    $count = 0;
    while($row = mysqli_fetch_array($query)){
        $AmountPaid = $row['AmountPaid'];
        $TimeStamp = $row['TimeStamp'];
        $ItemCode = $row['ItemCode'];
        $Description = $row['Description'];
        $label = $row['label'];
        $Discount = $row['Discount'];

        $count++;

        $html .= "
                    <tr>
                        <td>$count</td>
                        <td>$ItemCode</td>
                        <td>$Description</td>
                        <td>$AmountPaid</td>
                        <td>$Discount%</td>
                        <td>$TimeStamp</td>
                    </tr>
                ";
    }

    return $html;

}





function unsold(){
    $conn = dbconnect();
    $sql = "SELECT a.* FROM products a LEFT JOIN paymentstrail b ON b.ItemCode = a.ID AND b.IsCancelled is null WHERE b.ID IS NULL";

    $query = mysqli_query($conn, $sql);

    $html = "";
    $count = 0;
    while($row = mysqli_fetch_array($query)){
        $AmountPaid = number_format($row['Price'],2);
        $ItemCode = $row['ItemCode'];
        $Description = $row['Description'];

        $count++;

        $html .= "
                    <tr>
                        <td>$count</td>
                        <td>$ItemCode</td>
                        <td>$Description</td>
                        <td>$AmountPaid</td>
                    </tr>
                ";
    }

    return $html;

}
function damaged(){
    $conn = dbconnect();
    $sql = "SELECT b.Price as AmountPaid,a.TimeStamp, b.ItemCode, b.Description, IF(Action=1,'Damaged','Returned') as label FROM transactions a LEFT JOIN products b ON b.ItemCode=a.ItemCode WHERE a.Action = '1' AND a.TimeStamp ORDER BY TimeStamp";

    $query = mysqli_query($conn, $sql);

    $html = "";
    $count = 0;
    while($row = mysqli_fetch_array($query)){
        $AmountPaid = $row['AmountPaid'];
        $TimeStamp = $row['TimeStamp'];
        $ItemCode = $row['ItemCode'];
        $Description = $row['Description'];
        $label = $row['label'];

        $count++;

        $html .= "
                    <tr>
                        <td>$count</td>
                        <td>$ItemCode</td>
                        <td>$Description</td>
                        <td>$label</td>
                        <td>$AmountPaid</td>
                        <td>$TimeStamp</td>
                    </tr>
                ";
    }

    return $html;

}

?>