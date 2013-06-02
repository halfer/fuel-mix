<?php
	// Basic initialisation
	require_once 'lib/util.php';

	$root = dirname(__FILE__);
	$dbh = getDatabase($root . '/data/energy-mix.sqlite');
	$energyTypes = array('renewable', 'nuclear', 'coal', 'gas', 'other', );
?>
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
		<?php foreach ($energyTypes as $type): ?>
		<div id="container-<?php echo $type ?>" class="container"></div>

		<?php endforeach ?>

		<script type="text/javascript" src="js/flotr2.min.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript">
			(function () {

				function render() {

					<?php // Render the data from the database, in a format Flot2 likes ?>
					var renderer = new FuelMixRenderer();
					var data;
					<?php foreach ( $energyTypes as $type): ?>
						data = renderer.convertDateStringsToJSDate(
							<?php echo json_encode(
								getGraphDataForType($dbh, $type)
							) ?>
						);
						renderer.drawGraph(
							document.getElementById('container-<?php echo $type ?>'),
							data
						);
					<?php endforeach ?>
				}

				render();
			})();
		</script>
	</body>
</html>
