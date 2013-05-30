<!DOCTYPE html>
<html>
	<head>
		<title>Fuel Mix chart</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style type="text/css">
			body {
				margin: 0px;
				padding: 0px;
			}
			div.container {
				width : 500px;
				height: 300px;
				margin: 8px 0 0 8px;
				float: left;
			}
		</style>
	</head>
	<body>
		<div id="container1" class="container"></div>
		<div id="container2" class="container"></div>
		<div id="container3" class="container"></div>
		<div id="container4" class="container"></div>
		<div id="container5" class="container"></div>
		<script type="text/javascript" src="js/flotr2.min.js"></script>
		<script type="text/javascript">
			(function () {

				var
					start = new Date("2005/04/01 01:00").getTime(),
					year = 1000 * 60 * 60 * 24 * 365,
					graph;
				var
					data1, data2, data3, data4, data5;

				function drawGraph(container, data)
				{
					graph = Flotr.draw(
						container,
						data,
						{
							legend: {
								position: 'nw'
							},
							HtmlText: false,
							xaxis: {
								mode: 'time',
								showLabels: true,
								min: start
							},
							yaxis : {
								max : 100,
								min : 0
							},
							mouse: {
							}
						}
					);
				}

				function render() {

					data1 = [{
						data: [
							[ start + year * 0, 20.2 ],
							[ start + year * 1, 24.1 ],
							[ start + year * 2, 37.4 ],
							[ start + year * 3, 45.6 ],
							[ start + year * 4, 41.0 ],
							[ start + year * 5, 54.1 ],
							[ start + year * 6, 64.3 ]
						],
						label: 'Ecotricity (renewable)'
					}],
					data2 = [{
						data: [
							[ start + year * 2, 18 ],
							[ start + year * 3, 16 ],
							[ start + year * 4, 4.3 ],
							[ start + year * 5, 2.6 ],
							[ start + year * 6, 2.3 ]
						],
						label: 'Ecotricity (nuclear)'
					}],
					data3 = [{
						data: [
							[ start + year * 2, 18.3 ],
							[ start + year * 3, 17.1 ],
							[ start + year * 4, 20.2 ],
							[ start + year * 5, 17.5 ],
							[ start + year * 6, 12.1 ]
						],
						label: 'Ecotricity (coal)'
					}],
					data4 = [{
						data: [
							[ start + year * 2, 24.1 ],
							[ start + year * 3, 19.1 ],
							[ start + year * 4, 32.3 ],
							[ start + year * 5, 24.0 ],
							[ start + year * 6, 19.7 ]
						],
						label: 'Ecotricity (nat gas)'
					}],
					data5 = [{
						data: [
							[ start + year * 2, 2.2 ],
							[ start + year * 3, 2.2 ],
							[ start + year * 4, 2.2 ],
							[ start + year * 5, 1.8 ],
							[ start + year * 6, 1.6 ]
						],
						label: 'Ecotricity (other)'
					}];

					drawGraph(document.getElementById('container1'), data1);
					drawGraph(document.getElementById('container2'), data2);
					drawGraph(document.getElementById('container3'), data3);
					drawGraph(document.getElementById('container4'), data4);
					drawGraph(document.getElementById('container5'), data5);
				}

				render();
			})();
		</script>
	</body>
</html>
