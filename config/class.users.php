<?php

/**
 * 
 */
class Users
{
	#==============================
	# Display List of Users
	#==============================
	public function lists($value='')
	{
		$result = "";
		if($where){
			$where = " WHERE $where";
		}
		$sql = safe_query("SELECT * FROM users $where ");
		$c=0;
		while ($rw = mysqli_fetch_assoc($sql)) {
			$c++;
			$result .= "<tr>";
			$result .= "<td>$c</td>";
			$result .= "<td>{$rw['username']}</td>";
			$result .= "<td>{$rw['name']}</td>";
			$result .= "<td>".getUserLevel($rw['user_level'])."</td>";
			$result .= "<td>".getUserStatus($rw['status'])."</td>";
			$result .= "<td>".$this->getLastLogin($rw['username'])."</td>";
			$result .= "<td class='no-wrap'><button type='button' class='btn btn-success' onclick='editUser(\"{$rw['username']}\")'><i class='bi bi-pencil-square'></i></button>
							<button type='button' class='btn btn-danger' onclick='deleteProduct(\"{$rw['id']}\")'><i class='bi bi-trash3'></i></button></td>";
			$result .= "</tr>";
		}
		return $result;
	}
	public function getLastLogin($user=""){
		$sql = safe_query("SELECT * FROM logtrail WHERE username='$user' ORDER BY ID DESC LIMIT 1");
		if($rw = mysqli_fetch_assoc($sql)){
			return date("M d, Y h:i:s A", strtotime($rw['timestamp']));
		}
	}
	public function getTotalCountOfUsers(){
		$sql = safe_query("SELECT COUNT(*) as total FROM users");
		if($rw = mysqli_fetch_assoc($sql)){
			return $rw['total'];
		}
	}
}
$users = new Users();