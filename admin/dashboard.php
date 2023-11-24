
<?php include "config/load.php"; ?>
<div class="d-flex" style="justify-content: space-between">
<h3>Welcome <?=ucwords(strtolower($_SESSION['fullname']))?></h3>
<div class="d-flex"><h5>🗓️ <?=date('M d, Y')?>
<div class="d-flex mt-2"> 🕒 <div class="time-container-h"></div>:<div class="time-container-m"></div>:<div class="time-container-s"></div></div>
</h5></div>
</div>


<div class="row mt-5">
	<div class="col">
		<div class="card p-3 bg-success">
			<div class="card-title text-white"><h5>Total User</h5></div>
			<div class="card-body">
				<h2 class="text-white">👥 <?=$users->getTotalCountOfUsers()?></h2>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card p-3 bg-warning">
			<div class="card-title text-white"><h5>Total Sales</h5></div>
			<div class="card-body">
				<h2 class="text-white">💵 <?php echo $transactions->getTotalSales() != NULL ? $transactions->getTotalSales() : 0  ?></h2>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card p-3 bg-primary">
			<div class="card-title text-white"><h5>Transaction for this Month <small>(<?php echo date("F"); ?>)</small> </h5></div>
			<div class="card-body">
				<h2 class="text-white">🛍️ <?=$transactions->getTotalTransactionThisMonth()?> </h2>
			</div>
		</div>
	</div>
</div>

<div class="row mt-5">
	<div class="col-8">
		<div class="card p-3">
			<div class="card-title"><h5><?php echo date("Y") ?> Sales Summary per Month</h5></div>
			<div class="card-body">
				<div id="salespermonth"></div>
			</div>
		</div>
	</div>
	<div class="col-4">
		<div class="card p-3">
			<div class="card-title"><h5>Item Stocks</h5></div>
			<div class="card-body">
				<div id="itemtypestocks"></div>
			</div>
		</div>
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
	

	});



	var dataCount = []
	var dateName = []

	$.ajax({
		type: "POST",
		url: "dashboard_charts.php",
		data: {Action: 'donut'},
		success: function(x){
			let data = JSON.parse(x);
			$.each(data,function(id, value){
				dataCount.push(parseInt(value.Totals))
				dateName.push(value.Description)
			})

			// Donut chart
				var options = {
				series: dataCount,
				chart: {
					width: 380,
					type: 'donut',
				},
				labels: dateName,
				plotOptions: {
					pie: {
					startAngle: -90,
					endAngle: 270
					}
				},
				dataLabels: {
					enabled: false
				},
				fill: {
					type: 'gradient',
				},
				legend: {
					formatter: function(val, opts) {
					return val + " - " + opts.w.globals.series[opts.seriesIndex];
					}
				},
				responsive: [{
					breakpoint: 480,
					options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
					}
				}]
				};

				var chart = new ApexCharts(document.querySelector("#itemtypestocks"), options);
				chart.render();
		}
	})



	var barCount = []
	var barName = []
	$.ajax({
		type: "POST",
		url: "dashboard_charts.php",
		data: {Action: 'bar'},
		success: function(x){
			let data = JSON.parse(x);
			$.each(data,function(id, value){
				barCount.push(parseInt(value.Totals))
				barName.push(value.Description)
			})
			
			// Bar chart
			var options = {
			series: [{
			data: barCount
			}],
			chart: {
			type: 'bar',
			height: 350
			},
			plotOptions: {
			bar: {
				borderRadius: 4,
				horizontal: true,
			}
			},
			dataLabels: {
			enabled: false
			},
			xaxis: {
			categories:  barName,
			}
			};

			var chart = new ApexCharts(document.querySelector("#salespermonth"), options);
			chart.render();
			}
	})


	




		




</script>
