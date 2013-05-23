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
			#container {
				width : 800px;
				height: 600px;
				margin: 8px auto;
			}
		</style>
	</head>
	<body>
		<div id="container"></div>
		<script type="text/javascript" src="js/flotr2.min.js"></script>
		<script type="text/javascript">
			(function () {

				var
					container = document.getElementById('container'),
					start = new Date("2005/04/01 01:00").getTime(),
					year = 1000 * 60 * 60 * 24 * 365,
					data, graph;

				function render() {

					data = [{
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
					}, {
						data: [
							[ start + year * 0, 18 ], // Don't know
							[ start + year * 1, 18 ], // Don't know
							[ start + year * 2, 18 ],
							[ start + year * 3, 16 ],
							[ start + year * 4, 4.3 ],
							[ start + year * 5, 2.6 ],
							[ start + year * 6, 2.3 ]
						],
						label: 'Ecotricity (nuclear)'
					}, {
						data: [
							[ start + year * 0, 18.3 ], // Don't know
							[ start + year * 1, 18.3 ], // Don't know
							[ start + year * 2, 18.3 ],
							[ start + year * 3, 17.1 ],
							[ start + year * 4, 20.2 ],
							[ start + year * 5, 17.5 ],
							[ start + year * 6, 12.1 ]
						],
						label: 'Ecotricity (coal)'
					}, {
						data: [
							[ start + year * 0, 24.1 ], // Don't know
							[ start + year * 1, 24.1 ], // Don't know
							[ start + year * 2, 24.1 ],
							[ start + year * 3, 19.1 ],
							[ start + year * 4, 32.3 ],
							[ start + year * 5, 24.0 ],
							[ start + year * 6, 19.7 ]
						],
						label: 'Ecotricity (nat gas)'
					}, {
						data: [
							[ start + year * 0, 2.2 ], // Don't know
							[ start + year * 1, 2.2 ], // Don't know
							[ start + year * 2, 2.2 ],
							[ start + year * 3, 2.2 ],
							[ start + year * 4, 2.2 ],
							[ start + year * 5, 1.8 ],
							[ start + year * 6, 1.6 ]
						],
						label: 'Ecotricity (other)'
					}];

					// Draw Graph
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
								showLabels: true
							},
							yaxis : {
								max : 100,
								min : 0
							},
							mouse: {
							}
					});
				}

				render();
			})();
		</script>
	</body>
</html>
