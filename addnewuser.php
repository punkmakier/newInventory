<?php

// Autoloads functions and connection
include "config/load.php";
$title = "Add New User";
$required = "required";
$edit = '';
$userID='';
if(isset($_POST['user'])){
	$sql = safe_query("SELECT * FROM users WHERE username = '{$_POST['user']}'");
	$rw = mysqli_fetch_assoc($sql);
	$title = "Edit User";
	$required = "";
	$edit = "1";
	$userID = ",".$rw['id'];
}
?>
<!-- Modal -->
<div class="modal fade" id="AddNewUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel"><?=$title?></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row mb-1">
					<div class="col-lg-4">UserName</div>
					<div class="col-lg-8"><input type="text" class="form-control" name="uaUsername" id="uaUsername" value="<?= $rw['username']?>"></div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">Password</div>
					<div class="col-lg-8"><input type="password" class="form-control" name="uaPassword" id="uaPassword" <?=$required?>></div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">Full Name (<i>LN,FN,MN</i>)</div>
					<div class="col-lg-8"><input type="text" class="form-control" name="uaFullName" id="uaFullName" value="<?= $rw['name']?>"></div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">User Level</div>
					<div class="col-lg-8">
						<select class="form-control" name="uaUserLevel" id="uaUserLevel">
							<option value>- Select User Level -</option>
							<option value='1' <?=($rw['user_level']) == '1' ? "selected":""?>>Admin</option>
							<option value='3' <?=($rw['user_level']) == '3' ? "selected":""?>>Cashier</option>
						</select>
					</div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">User Status</div>
					<div class="col-lg-8">
						<select class="form-control" name="uaUserLevel" id="uaStatus">
							<option value>- Select User Status -</option>
							<option value='1' <?=($rw['status']) == '1' ? "selected":""?>>Active</option>
							<option value='2' <?=($rw['status']) == '2' ? "selected":""?>>Inactive</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="saveProduct(<?=$edit?> <?=$userID?>);">Save User</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function saveProduct(idx,uid){
		var form_data = {
			idx:idx,
			userid:uid,
			username:$("#uaUsername").val(),
			password:$("#uaPassword").val(),
			name:$("#uaFullName").val(),
			user_level:$("#uaUserLevel").val(),
			status:$("#uaStatus").val(),
		};
		$.ajax({
			url:"process.saveuser.php",
			type:"POST",
			data:form_data,
			success:function(x){
				if(x == 1){
					alert("User saved.");
					location.reload();
				}else if(x == 3){
					alert("Username is already existing.");
				}
			}

		})
	}
</script>