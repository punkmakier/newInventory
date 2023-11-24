<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<h1>Welcome <?=ucwords(strtolower($_SESSION['fullname']))?></h1>
<div class="row mt-5">
	<div class="col-lg-6">
		<table>
			<tr>
				<td style="padding-right: 15px;" width="180px">
					<img src="img/icons/calendar.png" height="110px" alt="">
				</td>
				<td>
					<h4>Today is: </h4> <h2><b class="date-container-full"><?=date('F d, Y')?></b> </h2>
				</td>
			</tr>
		</table>
	</div>
	<div class="col-lg-6">
		<table>
			<tr>
				<td style="padding-right: 15px;" width="180px">
					<img src="img/icons/clock.png" height="110px" alt="">
				</td>
				<td>
					<h1 class="time-container-h" style="font-weight: bold;">00</h1>
				</td>
				<td>
					<h1>:</h1>
				</td>
				<td>
					<h1 class="time-container-m" style="font-weight: bold;">00</h1>
				</td>
				<td>
					<h1>:</h1>
				</td>
				<td>
					<h1 class="time-container-s" style="font-weight: bold;">00</h1>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="row mt-5">
	<div class="col-lg-4">
		<table>
			<tr>
				<td style="padding-right: 15px;"><i class="bi bi-people-fill" style="font-size: 72px;"></i></td>
				<td><h4>Number of Users</h4><h3><?=$users->getTotalCountOfUsers()?></h3></td>
			</tr>
		</table>
	</div>
	<div class="col-lg-4">
		<table>
			<tr>
				<td style="padding-right: 15px;"><i class="bi bi-currency-dollar" style="font-size: 72px;"></i></td>
				<td><h4>Number of Transaction</h4><h3><?=$transactions->getTotalTransactions()?></h3></td>
			</tr>
		</table>
	</div>
	<div class="col-lg-4">
		<table>
			<tr>
				<td style="padding-right: 15px;"><i class="bi bi-people-fill" style="font-size: 72px;"></i></td>
				<td><h4>Top Selling Item Category</h4><div id="manual-charts"></div></td>
			</tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-lg-12" align="center">
		<h3><center><?=date('Y')?> Sales Summary per Month</center></h3>
		<div id="top_x_div" style="width: 100%;"></div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		// for the clock - start
		monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
		date = new Date();
		mnt = date.getMonth();
		date = String(date);
		time = date.split(" ");
		breakTime = time[4];
		currentTime = breakTime.split(":");
		hr = currentTime[0];
		mn = currentTime[1];
		sc = currentTime[2];
		var ampm = hr >= 12 ? 'pm' : 'am';
		hr = hr % 12;
		hr = hr ? (hr >=10 ? hr : "0"+hr) : 12; // the hour '0' should be '12'
		currentDate = monthNames[mnt]+" "+time[2]+", "+time[3];

		$(".date-container-full").html(currentDate);
		$(".time-container-h").html(hr);
		$(".time-container-m").html(mn);
		$(".time-container-s").html(sc+" "+ampm);
		sc++;
		setInterval(function(){
			date = new Date();
			mnt = date.getMonth();
			date = String(date);
			time = date.split(" ");
			breakTime = time[4];
			currentTime = breakTime.split(":");
			hr = currentTime[0];
			mn = currentTime[1];
			sc = currentTime[2];
			var ampm = hr >= 12 ? 'pm' : 'am';
			hr = hr % 12;
			hr = hr ? (hr >=10 ? hr : "0"+hr) : 12; // the hour '0' should be '12'
			currentDate = monthNames[mnt]+" "+time[2]+", "+time[3];

			$(".date-container-full").html(currentDate);
			$(".time-container-h").html(hr);
			$(".time-container-m").html(mn);
			$(".time-container-s").html(sc+" "+ampm);
			sc++;
		},1000);
		// for the clock - end
		$.ajax({
			url:"charts.topselling.php",
			success:function(x){
				$("#manual-charts").html(x);
			}
		});

	});

	google.charts.load('current', {'packages':['bar']});
	google.charts.setOnLoadCallback(drawStuff);

	function drawStuff() {
		var data = new google.visualization.arrayToDataTable([
			['Month', 'Total Sales'],
			[monthNames[0], <?=$transactions->getTotalTransactionsPerMonth(1)?>],
			[monthNames[1], <?=$transactions->getTotalTransactionsPerMonth(2)?>],
			[monthNames[2], <?=$transactions->getTotalTransactionsPerMonth(3)?>],
			[monthNames[3], <?=$transactions->getTotalTransactionsPerMonth(4)?>],
			[monthNames[4], <?=$transactions->getTotalTransactionsPerMonth(5)?>],
			[monthNames[5], <?=$transactions->getTotalTransactionsPerMonth(6)?>],
			[monthNames[6], <?=$transactions->getTotalTransactionsPerMonth(7)?>],
			[monthNames[7], <?=$transactions->getTotalTransactionsPerMonth(8)?>],
			[monthNames[8], <?=$transactions->getTotalTransactionsPerMonth(9)?>],
			[monthNames[9], <?=$transactions->getTotalTransactionsPerMonth(10)?>],
			[monthNames[10], <?=$transactions->getTotalTransactionsPerMonth(11)?>],
			[monthNames[11], <?=$transactions->getTotalTransactionsPerMonth(12)?>]
			]);

		var options = {
			legend: { position: 'none' },
			chart: { 

			},
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
          	x: {
              0: { side: 'Month'} // Top x-axis.
          }
      },
  };

  var chart = new google.charts.Bar(document.getElementById('top_x_div'));
  chart.draw(data, options);
};
</script>