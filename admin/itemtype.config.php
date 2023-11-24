<?php

?>
<div class="container-fluid">
	<div class="top-section">
		<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-3">
						<input type="hidden" id="txtItemTypeID">
						<label for="txtItemDesc">Item Type</label>
						<input type="text" name="txtItemTypeDesc" id="txtItemTypeDesc" class="form-control" value="<?=$_POST['txtItemTypeDesc']?>">
					</div>
					<div class="col-lg-6">
						<label>&nbsp;</label><br>
						<button type="button" class="btn btn-success" id="btnSave" onclick="saveItemType();">Save</button>
						<button type="button" class="btn btn-primary" id="btnUpdate" style="display:none;" onclick="updateItemType();">Update</button>
						<button type="button" class="btn btn-danger" id="btnCancel" style="display:none;" onclick="location.reload();">Cancel</button>
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
						<th>Item Type</th>
						<th>Stocks</th>
						<th width="1"></th>
					</tr>
				</thead>
				<tbody>
					<?=$products->itemTypeLists()?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function saveItemType(){
		$.ajax({
			async:false,
			url:"process.saveitemtype.php",
			type:"POST",
			data:{itemtype:$("#txtItemTypeDesc").val()},
			success:function(x){
				if(x==1){
					alert("Successfully saved.");
					location.reload();
				}
				if(x==3)alert("Item type is already existing.");
			}
		});
	}
	function updateItemType(){
		$.ajax({
			async:false,
			url:"process.saveitemtype.php",
			type:"POST",data:{
				id:$("#txtItemTypeID").val(),
				itemtype:$("#txtItemTypeDesc").val(),
			},
			success:function(x){
				if(x==1){
					alert("Successfully saved.");
					location.reload();
				}
				if(x==3)alert("Item type is already existing.");
			}
		});
	}
	function editItemType(id,desc){
		$("#btnSave").hide();
		$("#btnUpdate").show();
		$("#btnCancel").show();
		$("#txtItemTypeID").val(id);
		$("#txtItemTypeDesc").val(desc);
	}
	function saveItemType(){
		$.ajax({
			async:false,
			url:"process.saveitemtype.php",
			type:"POST",
			data:{itemtype:$("#txtItemTypeDesc").val()},
			success:function(x){
				if(x==1){
					alert("Successfully saved.");
					location.reload();
				}
				if(x==3)alert("Item type is already existing.");
			}
		});
	}
	function deleteItemType(id) {
		var ans = confirm("Are you sure you want to delete this?");
		if(ans){
			$.ajax({
				async:false,
				url:"process.saveitemtype.php",
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