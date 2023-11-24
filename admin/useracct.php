<div class="container-fluid">
	<div class="top-section">

		<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-3">
						<label for="txtItemCode">User Name</label>
						<input type="text" name="txtItemCode" id="txtItemCode" class="form-control" value="<?=isset($_POST['txtItemCode'])?>">
					</div>
					<div class="col-lg-3">
						<label for="txtItemDesc">Full Name</label>
						<input type="text" name="txtItemDesc" id="txtItemDesc" class="form-control" value="<?=isset($_POST['txtItemDesc'])?>">
					</div>
					<div class="col-lg-6">
						<label>&nbsp;</label><br>
						<button type="button" class="btn btn-success" onclick="searchUser('txtItemCode','txtItemDesc')">Search Entries</button>
						<button type="button" class="btn btn-danger" onclick="viewHistory()">View History</button>
						<button type="button" class="btn btn-primary" onclick="addNewUser()">Add User</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="body-section">
		<div class="table-responsive">
			<table class="table table-hover dt-active">
				<thead>
					<tr>
						<th>#</th>
						<th>User Name</th>
						<th>Full Name</th>
						<th>User Level</th>
						<th>User Status</th>
						<th>Last Login</th>
						<th width="1"></th>
					</tr>
				</thead>
				<tbody class="tbody">
					<?=$users->lists()?>
				</tbody>
			</table>
		</div>
	</div>
</div>




<!-- Modal -->
<div class="modal fade" id="viewHistoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel">Login History Logs</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class='table table-bordered' id='listOfHistoryLogs'>
					<thead>
						<th>Username</th>
						<th>Login logs</th>
					</thead>
					<tbody id='viewHistoryLogins'>

					</tbody>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
	function addNewUser(){
		$.ajax({
			async:false,
			url:"addnewuser.php",
			success:function(x){
				$("#popupbox").html(x);
				$("#AddNewUser").modal('show');
			}
		});
	}
	function editUser(user){
		$.ajax({
			async:false,
			url:"addnewuser.php",
			type:"POST",
			data:{user:user},
			success:function(x){
				$("#popupbox").html(x);
				$("#AddNewUser").modal('show');
			}
		});
	}

	function searchUser(uname,fname){
		var username = $("#"+uname).val()
		var fullname = $("#"+fname).val()

		$.ajax({
			async:false,
			url:"searchUser.php",
			type:"POST",
			data:{username : username, fullname : fullname},
			success:function(x){
				$(".tbody").html(x)
			}
		});

	}


	function viewHistory(){
		$.ajax({
			async:false,
			url:"viewhistory.php",
			type:"POST",
			data: {Action: ''},
			success:function(x){
				// $(".tbody").html(x)
				// alert(x)
				$("#viewHistoryLogins").html(x)
				$("#viewHistoryModal").modal('show');
		$("#listOfHistoryLogs").DataTable();

			}
		});
	}

	function deleteProduct($userid){
		$.ajax({
			async:false,
			url:"process.deleteuser.php",
			type:"POST",
			data: {uid: $userid},
			success:function(x){
				if(x === 'Success'){
					Swal.fire({
					title: "Success",
					text: "Deleted Successfully",
					icon: "success",
					showCancelButton: false,
					confirmButtonColor: "#3085d6",
					}).then((result) => {
					if (result.isConfirmed) {
						window.location.reload();
					}
					});
				}
			}
		});
	}
</script>