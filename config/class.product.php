<?php

/**
 * 
 */
class Products
{
	#==============================
	# Display List of Products
	#==============================
	public function lists($where="")
	{
		$result = "";
		if($where){
			$where = " WHERE $where";
		}
		$sql = safe_query("SELECT * FROM products $where ");
		$c=0;
		while ($rw = mysqli_fetch_assoc($sql)) {
			if($_SESSION['userlevel'] == 3){
				$clickable = "onclick='viewProduct(\"{$rw['ID']}\",\"{$rw['ItemCode']}\",\"{$rw['ItemName']}\")' style='cursor:pointer;'";
			}
			$c++;
			$result .= "<tr $clickable>";
			$result .= "<td>$c</td>";
			$result .= "<td>{$rw['ItemCode']}</td>";
			$result .= "<td>{$rw['ItemName']}</td>";
			$result .= "<td>{$rw['Description']}</td>";
			$result .= "<td>".$this->itemTypeDescription($rw['ItemType'])."</td>";
			$result .= "<td>{$rw['Size']}</td>";
			$result .= "<td>".number_format($rw['Price'],2)."</td>";
			if($_SESSION['userlevel'] == 1)$result .= "<td class='no-wrap'><button type='button' class='btn btn-success' onclick='editProduct(\"{$rw['ID']}\")'><i class='bi bi-pencil-square'></i></button>
							<button type='button' class='btn btn-danger' onclick='deleteProduct(\"{$rw['ID']}\")'><i class='bi bi-trash3'></i></button></td>";
			$result .= "</tr>";
		}
		return $result;
	}

	#==============================
	# Get Drop down of Products
	#==============================
	public function productsDropdown($value="")
	{
		$result = "<option value>- Select Product -</option>";
		$sql = safe_query("SELECT * FROM products ");
		while ($rw = mysqli_fetch_assoc($sql)) {
			$result .= "<option value='{$rw['ID']}' ".($value == $rw['ID'] ? "selected":"").">{$rw['ItemName']} (".$this->itemTypeDescription($rw['ItemType']).")</option>";
		}
		return $result;
	}
	#==============================
	# Display List of Item Types
	#==============================
	public function itemTypeLists()
	{
		$result = "";
		$sql = safe_query("SELECT * FROM itemtype ");
		$c=0;
		while ($rw = mysqli_fetch_assoc($sql)) {
			$sqlStocks = safe_query("SELECT COUNT(*) AS Totals FROM products WHERE ItemType = '{$rw['ID']}'");
			$stocks = "";
			if($rwStocks = mysqli_fetch_assoc($sqlStocks)){
				$stocks = $rwStocks['Totals'];
			}
			$c++;
			$result .= "<tr>";
			$result .= "<td>$c</td>";
			$result .= "<td>{$rw['Description']}</td>";
			$result .= "<td>$stocks</td>";
			$result .= "<td class='no-wrap'><button type='button' class='btn btn-success' onclick='editItemType(\"{$rw['ID']}\",\"{$rw['Description']}\")'><i class='bi bi-pencil-square'></i></button>
							<button type='button' class='btn btn-danger' onclick='deleteItemType(\"{$rw['ID']}\")'><i class='bi bi-trash3'></i></button></td>";
			$result .= "</tr>";
		}
		return $result;
	}
	#==============================
	# Get Drop down of Item Types
	#==============================
	public function itemTypeDropdown($value="")
	{
		$result = "<option value>- Select Item Type -</option>";
		$sql = safe_query("SELECT * FROM itemtype ");
		while ($rw = mysqli_fetch_assoc($sql)) {
			$result .= "<option value='{$rw['ID']}' ".($value == $rw['ID'] ? "selected":"").">{$rw['Description']}</option>";
		}
		return $result;
	}
	#==============================
	# Show Description of Item Types
	#==============================
	public function itemTypeDescription($value="")
	{
		$result = "";
		$sql = safe_query("SELECT * FROM itemtype WHERE ID='$value'");
		if ($rw = mysqli_fetch_assoc($sql)) {
			$result = $rw['Description'];
		}
		return $result;
	}
	#============================================================================
	public function getItemCode($value="")
	{
		$result = "";
		$sql = safe_query("SELECT * FROM products WHERE ID='$value'");
		if ($rw = mysqli_fetch_assoc($sql)) {
			$result = $rw['ItemCode'];
		}
		return $result;
	}
	public function getItemDesc($value="")
	{
		$result = "";
		$sql = safe_query("SELECT * FROM products WHERE ID='$value'");
		if ($rw = mysqli_fetch_assoc($sql)) {
			$result = $rw['ItemName'];
		}
		return $result;
	}
	public function getItemType($value="")
	{
		$result = "";
		$sql = safe_query("SELECT * FROM products WHERE ID='$value'");
		if ($rw = mysqli_fetch_assoc($sql)) {
			$result = $rw['ItemType'];
		}
		return $result;
	}
	public function getItemPrice($value="")
	{
		$result = "";
		$sql = safe_query("SELECT * FROM products WHERE ID='$value'");
		if ($rw = mysqli_fetch_assoc($sql)) {
			$result = $rw['Price'];
		}
		return $result;
	}
	public function getItemPricePerItemCode($value="")
	{
		$result = "";
		$sql = safe_query("SELECT * FROM products WHERE ItemCode='$value'");
		if ($rw = mysqli_fetch_assoc($sql)) {
			$result = $rw['Price'];
		}
		return $result;
	}
	public function getProductIDPerItemCode($value="")
	{
		$result = "";
		$sql = safe_query("SELECT * FROM products WHERE ItemCode='$value'");
		if ($rw = mysqli_fetch_assoc($sql)) {
			$result = $rw['Price'];
		}
		return $result;
	}
	public function showProductDatalist()
	{
		$sql = safe_query("SELECT a.* FROM products a LEFT JOIN paymentstrail b ON b.ItemCode = a.ID AND b.IsCancelled is null LEFT JOIN cart c ON c.Items=a.ItemCode LEFT JOIN transactions t ON t.ItemCode=a.ItemCode AND t.Action='1' WHERE b.ID IS NULL AND c.Items IS NULL AND t.ItemCode IS NULL");
		$return = "<datalist id='product-datalist'>";
		while ($rw = mysqli_fetch_assoc($sql)) {
			$return .=  "<option value='{$rw['ItemCode']}'>";
		}
		$return .= "</datalist>";
		return $return;
	}
	public function showAllProductDatalist()
	{
		$sql = safe_query("SELECT a.* FROM products a  LEFT JOIN transactions t ON t.ItemCode=a.ItemCode AND t.Action='1' LEFT JOIN paymentstrail p ON p.ItemCode = a.ID WHERE t.ItemCode IS NULL AND p.isCancelled IS NULL");
		$return = "<datalist id='product-datalist'>";
		while ($rw = mysqli_fetch_assoc($sql)) {
			$return .=  "<option value='{$rw['ItemCode']}' tag='{$rw['ItemCode']}'>";
		}
		$return .= "</datalist>";
		return $return;
	}
}
$products = new Products();