<?php 
include "config/load.php";

$sql = "SELECT * FROM logtrail ORDER BY timestamp DESC";
    // echo $sql;
$query = mysqli_query($conn, $sql);


if ($query) {
        $html = "";
        while ($rw = mysqli_fetch_assoc($query)) {
            // Process the data here
            $username = $rw['username'];
            $timestamp = $rw['timestamp'];
            $last_login = getLastLogin($username);

            $html .="
                        <tr>
                            <td>$username</td>
                            <td>$last_login</td>
                        </tr>
                    ";


        }

        echo $html;
}

function getLastLogin($user=""){
		$sql = safe_query("SELECT * FROM logtrail WHERE username='$user' ORDER BY ID DESC LIMIT 1");
		if($rw = mysqli_fetch_assoc($sql)){
			return date("M d, Y h:i:s A", strtotime($rw['timestamp']));
		}
	}




?>