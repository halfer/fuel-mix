<?php
	// Basic initialisation
	$root = dirname(__FILE__);
	$dbh = new PDO('sqlite:' . $root . '/data/energy-mix.sqlite');
	$energyTypes = array('renewable', 'nuclear', 'coal', 'gas', 'other', );

	function getDataForType(PDO $dbh, $shortName)
	{
		$sql = "
			SELECT
				supplier.name supplier_name,
				energy_type.name energy_type_name,
				mix_value.supplier_id,
				mix_value.date,
				mix_value.percent
			FROM
				mix_value
			INNER JOIN energy_type ON (mix_value.energy_type_id = energy_type.id)
			INNER JOIN supplier ON (supplier.id = mix_value.supplier_id)
			WHERE
				energy_type.short_name = :energy_type_short_name
			ORDER BY
				mix_value.supplier_id,
				mix_value.date
		";
		$sth = $dbh->prepare($sql);
		$sth->execute(
			array('energy_type_short_name' => $shortName)
		);

		$outData = array();
		foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			// Check an entry exists for this supplier
			$supplierName = $row['supplier_name'];
			if (!array_key_exists($supplierName, $outData))
			{
				$outData[$supplierName] = array();
			}

			// Add row
			$outData[$supplierName][] = $row;
		}

		return $outData;
	}

	function getGraphDataForType(PDO $dbh, $shortName)
	{
		$classes = array();

		$data = getDataForType($dbh, $shortName);
		$label = '';
		foreach ($data as $supplierName => $supplierData )
		{
			$class = new stdClass();

			$array = array();
			foreach ($supplierData as $row)
			{
				$array[] = array(
					$row['date'],
					(float) $row['percent']
				);
				$label = $supplierName . ' (' . $row['energy_type_name'] . ')';
			}
			$class->data = $array;
			$class->label = $label;
			$classes[] = $class;
		}

		return $classes;
	}

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
