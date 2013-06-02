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
			#supplier-list {
				margin: 8px;
				padding: 4px;
				background-color: #dddddd;
				border-radius: 8px;
				min-height: 22px;
				font-family: sans-serif;
				font-size: 0.8em;
			}
			.supplier-item {
				float: left;
				margin: 2px;
				padding: 5px;
				background-color: lightsteelblue;
				border-radius: 4px;
			}
			div.container {
				width : 500px;
				height: 300px;
				margin: 8px 0 0 8px;
				float: left;
			}
		</style>
		<script type="text/javascript" src="js/jquery-1.min.js"></script>
	</head>
	<body>
		<div id="supplier-list">
			<?php // Here's the supplier list ?>
			<?php foreach (getSupplierList($dbh) as $supplier): ?>
				<div class="supplier-item">
					<label>
						<input
							type="checkbox"
							id="supplier-tick-<?php echo $supplier['id'] ?>"
							class="supplier-tick"
							checked="checked"
						/>
						<?php echo htmlentities($supplier['name']) ?>
					</label>
				</div>
			<?php endforeach ?>
			<div style="clear:both;"/>
		</div>
		
		<?php // Here's the divs to hold the graphs ?>
		<?php foreach ($energyTypes as $type): ?>
			<div id="container-<?php echo $type ?>" class="container"></div>
		<?php endforeach ?>

		<script type="text/javascript" src="js/flotr2.min.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript">
			<?php // Set up all data as a JavaScript array ?>
			var renderer = new FuelMixRenderer();
			<?php foreach ( $energyTypes as $type): ?>
				var data<?php echo $type['id'] ?> = renderer.convertDateStringsToJSDate(
					<?php echo json_encode(
						getGraphDataForType($dbh, $type)
					) ?>
				);
			<?php endforeach ?>

			function render() {

				<?php // Render the data from the database, in a format Flot2 likes ?>
				<?php foreach ( $energyTypes as $type): ?>
					renderer.drawGraph(
						document.getElementById('container-<?php echo $type ?>'),
						renderer.getEnabledSuppliers(data<?php echo $type['id'] ?>)
					);
				<?php endforeach ?>
			}

			render();

			// Set up event to re-render if suppliers are changed
			$('.supplier-tick').click(render);
		</script>
	</body>
</html>
