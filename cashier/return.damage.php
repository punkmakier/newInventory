
<div class="row">
	<div class="col-lg-4">
		<div class="row mb-3">
			<div class="col-lg-12">
				<center><img src="img/logo2.jpg" width="60%"></center>
			</div>
		</div>
		<form id="frmReturn">
			<div class="row mb-1">
			<div class="row mb-1">
				<div class="col-lg-4">
					Item Code
				</div>
				<div class="col-lg-8">
					<input list='product-datalist' name="txtICode" id="txtICode" class="form-control" onchange="getProductDetails(this.value)" autocomplete="off">
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-lg-4">
					Item Name
				</div>
				<div class="col-lg-8">
					<input type="text" name="txtIDesc" id="txtIDesc" class="form-control" readonly="">
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-lg-4">
					Price
				</div>
				<div class="col-lg-8">
					<input type="text" name="txtIPrice" id="txtIPrice" class="form-control" readonly="">
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-lg-4">
					Date
				</div>
				<div class="col-lg-8">
					<input type="date" name="dateSubmit" id="dateSubmit"  class="form-control">
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-lg-4">
					Reason
				</div>
				<div class="col-lg-8">
					<textarea name="reason" id="reason" cols="30" rows="3" class="form-control"></textarea>
				</div>
			</div>

				<div class="col-lg-2">
					<button type="button" class="btn btn-success" onclick="submitReturn()">Submit</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-lg-8">
		<div class="item-cart-container p-3 table-responsive">
			<h4>Return History</h4>
			<table class="table table-bordered table-striped">
				<thead>
					<th>Item Code</th>
					<th>Item Name</th>
					<th>Price</th>
					<th>Label as</th>
					<th>Reason</th>
					<th>Date Return</th>
				</thead>
				<tbody id="listOfReturnProduct">
				</tbody>
			</table>
			
		</div>
	</div>
</div>
<?=$products->showAllProductDatalist();?>


<script>
	$(document).ready(function() {
		$.ajax({
			url:"fetch_returnproducts.php",
			type:"POST",
			data: {Action: ''},
			success:function(x){
				$("#listOfReturnProduct").empty().html(x)
			}
		});
	})
</script>

<script type="text/javascript">
	function getProductDetails(value){
		$.ajax({
			url:"fetch.productdata.php",
			type:"POST",
			data:{val:value},
			success:function(x){
				if(x==""){
					alert("Product does not exists");
					$("#txtICode").val("");
					$("#txtIDesc").val("");
					$("#txtIPrice").val("");
				}else{
					values = x.split("*");
					$("#txtICode").val(values[1]);
					$("#txtIDesc").val(values[2]);
					$("#txtIPrice").val(values[3]);
				}
			}
		});
	}

	function submitReturn(){
		$.ajax({
			url:"process.returnproduct.php",
			type:"POST",
			data: new FormData($("#frmReturn")[0]),
			contentType: false,
			processData: false,
			success:function(x){
				if(x === "Success"){
					Swal.fire({
					title: "Success",
					text: "Item has been mark as return",
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



	function appendToTable(value){
		$.ajax({
			url:"fetch.productdata.php",
			type:"POST",
			data:{val:value},
			success:function(x){
				if(x==""){
					alert("Product does not exists");
					$("#txtICode").val("");
				}else{
					values = x.split("*");
					$("#product-datalist").find("option[tag="+values[1]+"]").prop('disabled',true);
					$("#txtICode").val("");
					$("#items-here").append("<tr>"+
						"<td class='values' data='"+values[1]+"' data-price='"+values[3]+"'>"+values[1]+"</td>"+
						"<td>"+values[2]+"</td>"+
						"<td>"+values[3]+"</td>"+
						"<td><i class='bi bi-x-circle-fill' onclick='removetolist(this)' style='color:red;cursor:pointer'></i></td>"+
						"</tr>");
					computeLoop();
				}
			}
		});
	}
	function removetolist(obj) {
		val = $(obj).parent().parent().find(".values").attr("data");
		$(obj).parent().parent().remove();

		$("#product-datalist").find("option[tag="+val+"]").prop('disabled',false);
					computeLoop();
	}
	function processProduct() {
		labeled = "";
		$("input[name=prdStatus]").each(function(){
			if($(this).is(":checked")){
				labeled = $(this).val();
			}
		});
		allItems = "";
		add = "";
		$(".values").each(function(){
			allItems += add+$(this).attr('data');
			add = "~";
		});
		if(allItems==""){
			alert("No product is selected.");
			return false;
		}
		if(labeled==""){
			alert("Please select on Labeled as first.");
			return false;
		}
		var ans = confirm("Are you sure you want to process this items?");
		if(ans){
			$.ajax({
				url:"process.savetransactions.php",
				type:"POST",
				data:{
					items: allItems,
					stat: labeled,
				},
				success:function(x){
					alert("Successfully saved.");
				}
			});
		}
	}
	function computeLoop(){
		var totalPrice = 0 ;
		$(".values").each(function(){
			price = $(this).attr('data-price');
			totalPrice += parseFloat(price);
		});
		$("#total-amount-here").html(totalPrice);
	}
</script>