

<div class="top-section">
	<form method="post">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-4">
					<label>From Date</label>
					<input type="date" class="form-control" name="fdate" required value="<?= $_POST['fdate'] ?>">
				</div>
				<div class="col-lg-4">
					<label>To Date</label>
					<input type="date" class="form-control" name="tdate" required value="<?=$_POST['tdate']?>">
				</div>
				<div class="col-lg-4">
					<label>&nbsp;</label><br>
					<button type="submit" class="btn btn-success">Search Entries</button>
					<a href="printcollection.php" class="btn btn-primary" target="_blank">Print Collections</a>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="body-section">

		<nav>
			<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
				<a class="nav-item nav-link active" id="nav-show-1" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true" onclick="showStep(1)">Sold</a>
				<a class="nav-item nav-link" id="nav-show-2" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false" onclick="showStep(2)">Unsold</a>
				<a class="nav-item nav-link" id="nav-show-3" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false" onclick="showStep(3)">Return</a>
			</div>
		</nav>
		<div id="step1"style="transition:.3s">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th>#</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Price</th>
						<th>Discount</th>
						<th>Date Paid</th>
					</tr>
					<?php
					$fromDate = "2020-01-01";
					$toDate = date("Y-m-d");
					if(isset($_POST['fdate'])){
						$fromDate = date('Y-m-d',strtotime($_POST['fdate']));
					}
					if(isset($_POST['fdate'])){
						$toDate = date('Y-m-d',strtotime($_POST['tdate']));
					}


					$sql = safe_query("SELECT a.AmountPaid,a.TimeStamp,b.ItemCode,b.ItemName, 'Sold' as label,a.Discount FROM paymentstrail a LEFT JOIN products b ON b.ID = a.ItemCode WHERE IFNULL(isCancelled,'') <> '1' AND TimeStamp BETWEEN '".$fromDate." 00:00:00' AND '".$toDate." 23:59:59'");

				
					$c=0;
					$total=0;
					while ($rw = mysqli_fetch_assoc($sql)) { 
						// check if damaged
						$sqls = safe_query("SELECT 1 FROM transactions WHERE ItemCode ='{$rw['ItemCode']}' AND Action='1'");
						if(mysqli_num_rows($sqls)>0)continue;
						$c++;
						$total += $rw['AmountPaid'];
						?>
						<tr>
							<td><?=$c?></td>
							<td><?=$rw['ItemCode']?></td>
							<td><?=$rw['ItemName']?></td>
							<td><?=number_format($rw['AmountPaid'],2)?></td>
							<td><?=($rw['Discount'] ? $rw['Discount']:0)?>%</td>
							<td><?=date('M d, Y h:i A',strtotime($rw['TimeStamp']))?></td>
						</tr>
					<?php }
					?>
					<tr>
						<td colspan="4" align="right"><b>Total:</b></td>
						<td><b><?=number_format($total,2)?></b></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		<div id="step2" style="display:none;transition:.3s">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th>#</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Price</th>
					</tr>
					<?php
					$sql = safe_query("
					SELECT a.* FROM products a LEFT JOIN paymentstrail b ON b.ItemCode = a.ID AND b.IsCancelled is null WHERE b.ID IS NULL
						");
					$c=0;
					$total=0;
					while ($rw = mysqli_fetch_assoc($sql)) { 
						$c++;
						// $total += $rw['AmountPaid'];
						?>
						<tr>
							<td><?=$c?></td>
							<td><?=$rw['ItemCode']?></td>
							<td><?=$rw['ItemName']?></td>
							<td><?=number_format($rw['Price'],2)?></td>
						</tr>
					<?php }
					?>
					<!-- <tr>
						<td colspan="4" align="right"><b>Total:</b></td>
						<td><b><?=number_format($total,2)?></b></td>
						<td></td>
					</tr> -->
				</table>
			</div>
		</div>
		<div id="step3" style="display:none;transition:.3s">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th>#</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Labeled as</th>
						<th>Price</th>
						<th>Date Paid</th>
					</tr>
					<?php
			


					$sql = safe_query("SELECT
						b.Price as AmountPaid,a.TimeStamp, b.ItemCode, b.ItemName, IF(Action=1,'Damaged','Returned') as label
						FROM transactions a
						LEFT JOIN products b ON b.ItemCode=a.ItemCode
						WHERE a.Action = '1' AND
						a.TimeStamp BETWEEN '".$fromDate." 00:00:00' AND '".$toDate." 23:59:59' ORDER BY TimeStamp
						");

					$c=0;
					$total=0;
					while ($rw = mysqli_fetch_assoc($sql)) { 
						$c++;
						$total += $rw['AmountPaid'];
						?>
						<tr>
							<td><?=$c?></td>
							<td><?=$rw['ItemCode']?></td>
							<td><?=$rw['ItemName']?></td>
							<td><?=$rw['label']?></td>
							<td><?=number_format($rw['AmountPaid'],2)?></td>
							<td><?=date('M d, Y h:i A',strtotime($rw['TimeStamp']))?></td>
						</tr>
					<?php }
					?>
					<tr>
						<td colspan="4" align="right"><b>Total:</b></td>
						<td><b><?=number_format($total,2)?></b></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
</div>
<script>
	function showStep(step){
		switch(step){
		case 1:
			$("#nav-show-1").attr('aria-selected','true').addClass('active');
			$("#nav-show-2").attr('aria-selected','false').removeClass('active');
			$("#nav-show-3").attr('aria-selected','false').removeClass('active');
			$("#step1").show().css('opacity','1');
			$("#step2").hide().css('opacity','0');
			$("#step3").hide().css('opacity','0');
			break;
		case 2:
			$("#nav-show-1").attr('aria-selected','false').removeClass('active');
			$("#nav-show-2").attr('aria-selected','true').addClass('active');
			$("#nav-show-3").attr('aria-selected','false').removeClass('active');
			$("#step1").hide().css('opacity','0');
			$("#step2").show().css('opacity','1');
			$("#step3").hide().css('opacity','0');
			break;
		case 3:
			$("#nav-show-1").attr('aria-selected','false').removeClass('active');
			$("#nav-show-2").attr('aria-selected','false').removeClass('active');
			$("#nav-show-3").attr('aria-selected','true').addClass('active');
			$("#step1").hide().css('opacity','0');
			$("#step2").hide().css('opacity','0');
			$("#step3").show().css('opacity','1');
			break;
		}
	}
</script>