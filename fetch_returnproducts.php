<?php 

include "config/load.php";

$sql = "SELECT b.Price as AmountPaid,a.TimeStamp, b.ItemCode, b.ItemName, IF(Action=1,'Damaged','Returned') as label, a.reason, a.return_date
FROM transactions a LEFT JOIN products b ON b.ItemCode=a.ItemCode
WHERE a.Action = '1' AND a.TimeStamp ORDER BY TimeStamp";

$query = mysqli_query($conn, $sql);


if ($query) {
    $html = "";
    if(mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)){
            $ItemCode = $row['ItemCode'];
            $ItemName = $row['ItemName'];
            $AmountPaid = $row['AmountPaid'];
            $label = $row['label'];
            $reason = $row['reason'];
            $return_date = $row['return_date'];

            $html .= "
                        <tr>
                            <td>$ItemCode</td>
                            <td>$ItemName</td>
                            <td>$AmountPaid</td>
                            <td>$label</td>
                            <td>$reason</td>
                            <td>$return_date</td>
                        </tr>
                    ";
        }
    }
    else{
        $html = "No data has found.";
    }



    echo $html;
}


?>