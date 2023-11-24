<?php

#====================================
# Autoloads functions and connection
#====================================
include "config/load.php";

switch($_POST['type']){
	case 'S':
		$customerLabel = "Customer's Name";
		$ReceiptPart = "style='display:none;'";
		break;
	case 'D':
		$customerLabel = "";
		$customerPart = "style='display:none;'";
		$ReceiptPart = "style='display:none;'";
		break;
	case 'R':
		$customerLabel = "Returned by";
		$QuantityPart = "style='display:none;'";
		break;
}
?>
<input type="hidden" name="ppProcessProduct" value="<?=$_POST['prdct']?>">
<input type="hidden" name="ppProcessType" value="<?=$_POST['type']?>">

<div class="row mb-1">
	<div class="col-lg-12">
		<label>Item Code</label>
		<input type="text" name="ppItemCode" id="ppItemCode" class="form-control" readonly value="<?=$products->getItemCode($_POST['prdct'])?>">
	</div>
</div>
<div class="row mb-1">
	<div class="col-lg-12">
		<label>Description</label>
		<input type="text" name="ppItemDesc" id="ppItemDesc" class="form-control" readonly value="<?=$products->getItemDesc($_POST['prdct'])?>">
	</div>
</div>
<div class="row mb-1">
	<div class="col-lg-12">
		<label>Item Type</label>
		<input type="text" name="ppItemType" id="ppItemType" class="form-control" readonly value="<?=$products->itemTypeDescription($products->getItemType($_POST['prdct']))?>">
	</div>
</div>
<div class="row mb-1">
	<div class="col-lg-12">
		<label>Item Price</label>
		<input type="text" name="ppItemPrice" id="ppItemPrice" class="form-control" readonly value="<?=number_format($products->getItemPrice($_POST['prdct']),2)?>">
	</div>
</div>
<div class="row mb-1" <?=$customerPart?>>
	<div class="col-lg-12">
		<label><?=$customerLabel?></label>
		<input type="text" name="ppItemCustomer" id="ppItemCustomer" class="form-control">
	</div>
</div>
<div class="row mb-1" <?=$QuantityPart?>>
	<div class="col-lg-12">
		<label>Quantity</label>
		<input type="number" min=1 name="ppQuantity" id="ppQuantity" class="form-control">
	</div>
</div>
<div class="row mb-1" <?=$ReceiptPart?>>
	<div class="col-lg-12">
		<label>Receipt No. / OR</label>
		<input type="text" name="ppORNo" id="ppORNo" class="form-control">
	</div>
</div>