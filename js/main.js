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
					min : 0
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
		for(index in data[0].data)
		{
			var dateStr = data[0].data[index][0];
			data[0].data[index][0] = new Date(dateStr);
		}

		return data;
	};
}

