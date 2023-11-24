<?php

function getWhereClause(){
	if($_POST['txtItemCode']){
		$where[] = " ItemCode LIKE '%{$_POST['txtItemCode']}%' ";
	}
	if($_POST['txtItemDesc']){
		$where[] = " Description LIKE '%{$_POST['txtItemDesc']}%' ";
	}
	if($where) $whereClause = implode(" AND ", $where);
	return $whereClause;
}
?>
<div class="container-fluid">
	<div class="top-section">
		<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-3">
						<label for="txtItemCode">Item Code</label>
						<input type="text" name="txtItemCode" id="txtItemCode" class="form-control" value="<?=$_POST['txtItemCode']?>">
					</div>
					<div class="col-lg-3">
						<label for="txtItemDesc">Description</label>
						<input type="text" name="txtItemDesc" id="txtItemDesc" class="form-control" value="<?=$_POST['txtItemDesc']?>">
					</div>
					<div class="col-lg-6">
						<label>&nbsp;</label><br>
						<button type="submit" class="btn btn-success">Search Entries</button>
						<button type="button" class="btn btn-primary" onclick="addNewProduct()">Add Product</button>
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
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Description</th>
						<th>Item Type</th>
						<th>Size</th>
						<th>Price</th>
						<th width="1"></th>
					</tr>
				</thead>
				<tbody>
					<?=$products->lists(getWhereClause())?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function generateItemCode(){
		$.ajax({
			url:"generate.itemcode.php",
			success:function(x){
				$("#aiItemCode").val(x);
			}
		});
	}
	function addNewProduct(){
		$.ajax({
			async:false,
			url:"addnewproduct.php",
			success:function(x){
				$("#popupbox").html(x);
				$("#AddingItem").modal('show');
			}
		});
		generateItemCode();
	}
	function editProduct(id){
		$.ajax({
			async:false,
			url:"addnewproduct.php",
			type:"POST",
			data:{id:id},
			success:function(x){
				$("#popupbox").html(x);
				$("#AddingItem").modal('show');
			}
		});
	}
	function deleteProduct(id) {
		var ans = confirm("Are you sure you want to delete this?");
		if(ans){
			$.ajax({
				async:false,
				url:"process.saveproduct.php",
				type:"POST",
				data:{isDelete:1,id:id},
				success:function(x){
					alert("Successfully deleted.");
					location.reload();
				}
			});
		}
	}
</script>