<div class="top-section" align="right">
	<button class="btn btn-primary"><?=date("F d, Y")?></button>
</div>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Transaction ID</th>
				<th>Item Code</th>
				<th>Item Description</th>
				<th>Price</th>
				<th>Amount Received</th>
				<th>Changed</th>
				<th>Date Transaction</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$sql = safe_query("SELECT * FROM paymentstrail as p INNER JOIN products as pr ON p.ItemCode = pr.ID WHERE IFNULL(p.isCancelled, '') <> '1';
					");
					
				$c=0;
				$overallPrice = 0;
				while ($rw = mysqli_fetch_assoc($sql)) {$c++;
					$changed = ($rw['AmountTendered'] - $rw['AmountPaid']);
					echo "
						<tr>
							<td>{$rw['ORNo']}</td>
							<td>{$rw['ItemCode']}</td>
							<td>{$rw['Description']}</td>
							<td>".number_format($rw['AmountPaid'],2)."</td>
							<td>".number_format($rw['AmountTendered'],2)."</td>
							<td>".number_format($changed,2)."</td>
							<td>$c. ".date('M d, Y h:i A',strtotime($rw['TimeStamp']))."</td>
			
						</tr>";
						$overallPrice += $rw['AmountPaid'];
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6" align="right">Total:</td>
				<td align='right'><?=number_format($overallPrice,2)?></td>
			</tr>
		</tfoot>
	</table>
</div>