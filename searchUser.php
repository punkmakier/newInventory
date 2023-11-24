<?php 
include "config/load.php";

if(isset($_POST['username']) || isset($_POST['fullname'])){
    $uname = trim($_POST['username']);
    $fname = trim($_POST['fullname']);
    $nameHolder = "";
    $fnameHolder = "";
    if($uname){
        $nameHolder = " AND username LIKE '%$uname%'";
    }
    if($fname){
       $fnameHolder = " AND `name` LIKE '%$fname%'";
    }

    $sql = "SELECT * FROM users WHERE  username != '' $nameHolder $fnameHolder";
    // echo $sql;
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $html = "";
        while ($rw = mysqli_fetch_assoc($query)) {
            // Process the data here
            $no = $rw['id'];
            $username = $rw['username'];
            $fname = $rw['name'];
            $level = getUserLevel($rw['user_level']);
            $status = getUserStatus($rw['status']);
            $last_login = $rw['last_login'];

            $last_login = getLastLogin($username);

            $html .= "<tr>
                        <td>$no</td>
                        <td>$username</td>
                        <td>$fname</td>
                        <td>$level</td>
                        <td>$status</td>
                        <td>$last_login</td>
                        <td class='no-wrap'><button type='button' class='btn btn-success' onclick='editUser(\"{$rw['username']}\")'><i class='bi bi-pencil-square'></i></button>
							<button type='button' class='btn btn-danger' onclick='deleteProduct(\"{$rw['id']}\")'><i class='bi bi-trash3'></i></button></td>
                    </tr>";
        }

        echo $html;
    } else {
        // Handle the case where the query failed
        echo "Error in query: " . mysqli_error($conn);
    }
}
else{
    $sql = "SELECT * FROM users";
    // echo $sql;
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $html = "";
        while ($rw = mysqli_fetch_assoc($query)) {
            // Process the data here
            $no = $rw['id'];
            $username = $rw['username'];
            $fname = $rw['name'];
            $level = getUserLevel($rw['user_level']);
            $status = getUserStatus($rw['status']);
            $last_login = $rw['last_login'];

            $last_login = getLastLogin($username);

            $html .= "<tr>
                        <td>$no</td>
                        <td>$username</td>
                        <td>$fname</td>
                        <td>$level</td>
                        <td>$status</td>
                        <td>$last_login</td>
                        <td class='no-wrap'><button type='button' class='btn btn-success' onclick='editUser(\"{$rw['username']}\")'><i class='bi bi-pencil-square'></i></button>
							<button type='button' class='btn btn-danger' onclick='deleteProduct(\"{$rw['no']}\")'><i class='bi bi-trash3'></i></button></td>
                    </tr>";
        }

        echo $html;
    }
}


function getLastLogin($user=""){
		$sql = safe_query("SELECT * FROM logtrail WHERE username='$user' ORDER BY ID DESC LIMIT 1");
		if($rw = mysqli_fetch_assoc($sql)){
			return date("M d, Y h:i:s A", strtotime($rw['timestamp']));
		}
	}


?>