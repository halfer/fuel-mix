<?php
	# Basic initialisation
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
				date,
				mix_value.percent
			FROM
				mix_value
			INNER JOIN energy_type ON (mix_value.energy_type_id = energy_type.id)
			INNER JOIN supplier ON (supplier.id = mix_value.supplier_id)
			WHERE
				energy_type.short_name = :energy_type_short_name
		";
		$sth = $dbh->prepare($sql);
		$sth->execute(
			array('energy_type_short_name' => $shortName)
		);

		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	function getGraphDataForType(PDO $dbh, $shortName)
	{
		$class = new stdClass();

		$data = getDataForType($dbh, $shortName);
		$array = array();
		$label = '';
		foreach ($data as $row)
		{
			$array[] = array(
				$row['date'],
				(float) $row['percent']
			);
			$label = $row['supplier_name'] . ' (' . $row['energy_type_name'] . ')';
		}

		$class->data = $array;
		$class->label = $label;

		return $class;
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
								max : 102,
								min : 0
							},
							mouse: {
							}
						}
					);
				}

				function render() {

					/**
					 * Converts a data structure containing string dates to use Date types
					 * 
					 * @param data
					 * @returns Array
					 */
					function convertDateStringsToJSDate(data)
					{
						for(index in data[0].data)
						{
							var dateStr = data[0].data[index][0];
							data[0].data[index][0] = new Date(dateStr);
						}
						
						return data;
					}

					<?php // Render the data from the database, in a format Flot2 likes ?>
					<?php foreach ( $energyTypes as $ord => $type): ?>
						data<?php echo $ord + 1 ?> = convertDateStringsToJSDate(
							[
								<?php echo json_encode(
									getGraphDataForType($dbh, $type)
								) ?>
							]
						);
					<?php endforeach ?>

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
