function FuelMixRenderer()
{
	/**
	 * Draw a single time line chart
	 * 
	 * @param container
	 * @param data
	 * @returns void
	 */
	this.drawGraph = function(container, data)
	{
		var
			start = new Date("2005/04/01 01:00").getTime(),
			graph;

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
					min : -2
				},
				mouse: {
				}
			}
		);
	};

	/**
	 * Converts a data structure containing string dates to use Date types
	 * 
	 * @param data
	 * @returns Array
	 */
	this.convertDateStringsToJSDate = function(data)
	{
		for(var outerIndex in data)
		{
			for(var innerIndex in data[outerIndex].data)
			{
				var dateStr = data[outerIndex].data[innerIndex][0];
				data[outerIndex].data[innerIndex][0] = new Date(dateStr);
			}
		}

		return data;
	};

	this.getEnabledSuppliers = function(data) {

		// Get a list of suppliers we should render
		var suppliers = new Array();
		$('.supplier-tick').each(
			function(index, el)
			{
				var qel = $(el);
				var id = el.id.replace('supplier-tick-', '');
				if (qel.is(':checked'))
				{
					suppliers.push(id);
				}
			}
		);

		// Only copy the data where suppliers are selected
		var thisSupplierId;
		var newData = new Array();
		var newSupplier;
		for(var outerIndex in data)
		{
			thisSupplierId = data[outerIndex].supplier_id;
			if (suppliers.indexOf(thisSupplierId) > -1)
			{
				// Recreate the supplier object, skipping the supplier_id
				var newSupplier = new Object();
				newSupplier.data = data[outerIndex].data;
				newSupplier.label = data[outerIndex].label;
				newData.push(newSupplier);
			}
		}

		return newData;
	};
}

