
<div class="row">
	<div class="col-lg-4">
		<div class="row mb-3">
			<div class="col-lg-12">
				<center><img src="img/logo2.jpg" width="60%"></center>
			</div>
		</div>
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
				Item Description
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
				&nbsp;
			</div>
			<div class="col-lg-8">
				<button class="btn btn-success" style="width: 59%;" onclick="setToCart()">Add</button>
				<button class="btn btn-danger" style="width: 39%;" onclick="resetFields()">Reset</button>
			</div>
		</div>
		<div class="row mb-1">
			<div class="col-lg-4">
				&nbsp;
			</div>
			<div class="col-lg-8">
				<button class="btn btn-primary" style="width: 100%;" onclick="proceedToPayment()">Proceed Payment</button>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="item-cart-container table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Item Code</th>
						<th>Item Description</th>
						<th>Price</th>
						<th width="1">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="cart-here"></tbody>
				<tfoot id="total-cart-here">
					<tr>
						<td style="border:none;" colspan="4" align="right">
							<h4>Total Amount: <font id="total-amount-here">0.00</font></h4>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?=$products->showProductDatalist();?>

<!-- Modal -->
<div class="modal fade" id="computenow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="computebody"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" onclick="paynow()">Pay now</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="finishmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="finishmodalBody">
				<div class="ORPart" align="center"></div>
				<div class="ChangePart" align="center"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="location.reload()">Close</button>
			</div>
		</div>
	</div>
</div>

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
	function setToCart(){
		value = $("#txtICode").val();
		if(value == ""){
			alert("Please select a product first.");
		}
		$.ajax({
			url:"addtocart.php",
			type:"POST",
			data:{val:value},
			success:function(x){
				location.reload();
				$("#txtICode").val("");
				$("#txtIDesc").val("");
				$("#txtIPrice").val("");
			}
		});
	}
	function removeToCart(value){
		$.ajax({
			url:"removeToCart.php",
			type:"POST",
			data:{val:value},
			success:function(x){
				location.reload();
			}
		});
	}
	function loadCart(){
		value = $("#txtICode").val();
		$.ajax({
			url:"load.cart.php",
			type:"POST",
			data:{val:value},
			success:function(x){
				values = x.split("*");
				$("#cart-here").html(values[0]);
				$("#total-amount-here").html(values[1]);
			}
		});
	}
	loadCart();
	function proceedToPayment(){
		$.ajax({
			url:"compute.cart.php",
			success:function(x){
				$("#computebody").html(x);
				$("#computenow").modal('show');
			}
		});
	}
	function paynow() {
		var items = $("#allItems").val();
		var amtTendered = $("#amount-tendered").val();
		var discount = $("#discount").val();
		if(items==""){
			alert("Please select a product first.");
			return false;
		}
		if(amtTendered==""){
			alert("Please input amount received.");
			return false;
		}
		$.ajax({
			url:"process.payments.php",
			type:"POST",
			data:{
				items:items,
				amtTendered:amtTendered,
				discount:discount,
			},success:function(x){
				returns = x.split("~");
				$(".ORPart").html("OR Number: "+returns[0]);
				$(".ChangePart").html("Change: "+addCommas(returns[1]));
				$("#computenow").modal('hide');
				$("#finishmodal").modal('show',{
					backdrop:'static',
					keyboard:false,
				});
			}
		});
	}

	function resetFields(){
			$("#txtICode").val("");
			$("#txtIDesc").val("");
			$("#txtIPrice").val("");
	}
</script>