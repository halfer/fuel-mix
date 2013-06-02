<?php

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

function getDatabase($dataFile)
{
	// Check we have PDO and SQLite available
	if (!extension_loaded('PDO') || !extension_loaded('pdo_sqlite'))
	{
		echo 'This application needs the `PDO` and `pdo_sqlite` modules';
		exit();
	}

	return new PDO('sqlite:' . $dataFile);
}