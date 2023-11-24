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
<input type="hidden" id="selectedProductID" value="">
<input type="hidden" id="selectedProductCode" value="">
<input type="hidden" id="selectedProductDesc" value="">
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
						<th>Description</th>
						<th>Item Type</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?=$products->lists(getWhereClause())?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="transactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5 transactModalTitle">Process Item</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="form-group mb-3">
						<div class="row">
							<button type="button" class="btn btn-success btn-lg" onclick="processProduct('S')">Mark as Sold</button>
						</div>
					</div>
					<div class="form-group mb-3">
						<div class="row">
							<button type="button" class="btn btn-primary btn-lg" onclick="processProduct('D')">Mark as Damaged Item</button>
						</div>
					</div>
					<div class="form-group mb-3">
						<div class="row">
							<button type="button" class="btn btn-warning btn-lg" onclick="processProduct('R')">Mark as Returned Item</button>
						</div>
					</div>
					<div class="form-group mb-3">
						<div class="row">
							<button type="button" class="btn btn-danger btn-lg" data-bs-dismiss='modal'>Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="processProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title transactModalTitle2" style="font-size: 15px;">Process Item</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="processProductBody"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary">Process</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function viewProduct(id,code,desc){


		$(".transactModalTitle").html("Process Item: "+code+" - "+desc);
		$("#selectedProductID").val(id);
		$("#selectedProductCode").val(code);
		$("#selectedProductDesc").val(desc);
		$("#transactModal").modal('show');
	}
	function processProduct(type){

		var code = $("#selectedProductCode").val();
		var desc = $("#selectedProductDesc").val();
		switch(type){
			case'S':
				typeDesc = "Mark as Sold";
			break;
			case'D':
				typeDesc = "Mark as Damaged Item";
			break;
			case'R':
				typeDesc = "Mark as Returned Item";
			break;
		}
		$.ajax({
			url:"process.transactproduct.php",
			type:"POST",
			data:{
				type:type,
				prdct:$("#selectedProductID").val(),
			},
			success:function(x){
				$(".transactModalTitle2").html("Process Item: "+code+" - "+desc +" ("+typeDesc+")");
				$("#processProductBody").html(x);
				$("#processProduct").modal('show');
			}
		})
	}
	function saveProcessProduct(){
		var ItemCode = $("#ppItemCode").val();
		var ItemDesc = $("#ppItemDesc").val();
		var ItemType = $("#ppItemType").val();
		var ItemPrice = $("#ppItemPrice").val();
		var ItemCustomer = $("#ppItemCustomer").val();
		var Quantity = $("#ppQuantity").val();
		var ORNo = $("#ppORNo").val();
		var ProcessProduct = $("#ppProcessProduct").val();
		var ProcessType = $("#ppProcessType").val();

		form_data = {
			ItemCode:ItemCode,
			ItemDesc:ItemDesc,
			ItemType:ItemType,
			ItemPrice:ItemPrice,
			ItemCustomer:ItemCustomer,
			Quantity:Quantity,
			ORNo:ORNo,
			ProcessProduct:ProcessProduct,
			ProcessType:ProcessType,

		};
		$.ajax({
			url:"process.savetransactions.php",
			type:"POST",
			data:form_data,
			success:function(x){
				if(x==1){
					alert("Successfully saved.");
				}else{
					alert("There is something wrong. Please try again later.");
				}
			}
		})
	}
</script>