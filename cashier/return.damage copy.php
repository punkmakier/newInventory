
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
			<div class="col-lg-6">
				<input list='product-datalist' name="txtICode" id="txtICode" class="form-control" onchange="getProductDetails(this.value)">
			</div>
			<div class="col-lg-2">
				<button class="btn btn-success" onclick="appendToTable($('#txtICode').val())">Add</button>
			</div>
		</div>

	</div>
	<div class="col-lg-6">
		<div class="item-cart-container table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th style="border:none;text-align: center;" colspan="4"><h4>Return & Damaged</h4></th>
					</tr>
					<tr>
						<th style="border:none;" colspan="2" width="60%"><h4>Date</h4></th>
						<th style="border:none;"><input type="text" class="form-control" readonly value="<?=date('m-d-y')?>"></th>
					</tr>
					<tr>
						<th style="border:none;" colspan="2" width="60%"><h4>Labeled as:</h4></th>
						<th style="border:none;">
							<input type="radio" name="prdStatus" value="1" style="width: 20px;height:20px;vertical-align: -4px;"> Damaged<br>
							<input type="radio" name="prdStatus" value="2" style="width: 20px;height:20px;vertical-align: -4px;"> Return
						</th>
					</tr>
					<tr>
						<th style="border:none;text-align: center;" colspan="4"><h4>----------------------------------------------------</h4></th>
					</tr>
					<tr>
						<th>Item Code</th>
						<th>Description</th>
						<th>Price</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="items-here">
					
				</tbody>
				<tfoot id="total-cart-here">
					<tr>
						<td style="border:none;text-align: center;" colspan="4"><h4>----------------------------------------------------</h4></td>
					</tr>
					<tr>
						<td style="border:none;" colspan="4" align="right">
							<h4>Total Amount: <font id="total-amount-here">0.00</font></h4>
						</td>
					</tr>
					<tr>
						<td style="border:none;" colspan="4" align="center">
							<button type="button" class="btn btn-primary" onclick="processProduct()">Process</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?=$products->showAllProductDatalist();?>

<script type="text/javascript">
	function getProductDetails(value){
		
		if($("#product-datalist").find("option[tag="+value+"]").prop('disabled')){
			alert("Product is already added.");
			$("#txtICode").val("");
		}
		if($("#product-datalist").find("option[tag="+value+"]").val()==undefined){
			alert("Product does not exists");
			$("#txtICode").val("");
		}
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