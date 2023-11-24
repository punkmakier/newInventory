<?php

// Autoloads functions and connection
include "config/load.php";

if($_POST['id']){
	$sql = safe_query("SELECT * FROM products WHERE ID = '{$_POST['id']}'");
	$rw=mysqli_fetch_assoc($sql);
}
?>
<!-- Modal -->
<div class="modal fade" id="AddingItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel">Add Item</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row mb-1">
					<div class="col-lg-4">Item Code</div>
					<div class="col-lg-8"><input type="text" class="form-control" name="aiItemCode" id="aiItemCode" value="<?=$rw['ItemCode']?>" readonly></div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">Item Name</div>
					<div class="col-lg-8"><input type="text" class="form-control" name="aiItemName" id="aiItemName" value="<?=$rw['ItemName']?>"></div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">Item Description</div>
					<div class="col-lg-8"><input type="text" class="form-control" name="aiItemDesc" id="aiItemDesc" value="<?=$rw['Description']?>"></div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">Size</div>
					<div class="col-lg-8"><input type="text" class="form-control" name="aiItemSize" id="aiItemSize" value="<?=$rw['Size']?>"></div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">Price</div>
					<div class="col-lg-8"><input type="text" class="form-control amounts" name="aiItemPrice" id="aiItemPrice" value="<?=$rw['Price']?>"></div>
				</div>
				<div class="row mb-1">
					<div class="col-lg-4">Item Type</div>
					<div class="col-lg-8">
						<select type="text" class="form-control" name="aiItemType" id="aiItemType">
							<?=$products->itemTypeDropdown($rw['ItemType'])?>
						</select>
					</div>
				</div>
				<!-- <div class="row mb-1">
					<div class="col-lg-4">Quantity</div>
					<div class="col-lg-8"><input type="number" min="0" class="form-control" name="aiQuantity" id="aiQuantity" value="<?=$rw['Quantity']?>"></div>
				</div> -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="saveProduct('<?=$_POST['id']?>');">Save changes</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function saveProduct(idx){
		var form_data = {
			idx:idx,
			code:$("#aiItemCode").val(),
			desc:$("#aiItemDesc").val(),
			price:$("#aiItemPrice").val(),
			type:$("#aiItemType").val(),
			name:$("#aiItemName").val(),
			size:$("#aiItemSize").val(),
		};
		$.ajax({
			url:"process.saveproduct.php",
			type:"POST",
			data:form_data,
			success:function(x){
				if(x == 1){
					alert("Product saved.");
					location.reload();
				}else if(x == 3){
					alert("Product code is already existing.");
				}
			}

		})
	}
</script>