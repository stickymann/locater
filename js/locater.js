
$(document).ready(function()
{
	$('#whereis').click( function() { locater.WhereIs(); });
	$('#locate').click( function() { locater.Locate(); });
});

var locater = new function()
{
	this.WhereIs = function ()
	{
		var lat = $('#lat').val();
		var lon = $('#lon').val();
		var notification = "<div>WHEREIS request sent for coordinates (" + lat + "," + lon + ")</div>";
		this.UpdateResultDiv( notification );
		var params = "option=whereis&lat=" + lat + "&lon=" + lon;
		var query_url = siteutils.getAjaxURL() + params;
		$.getJSON(query_url, function(data) 
		{  
			value = data.value;
			view_url = data.view_url;
			console.log(data);
			console.log(data.value);
			notification = "<div>WHEREIS result for coordinates (" + lat + "," + lon + "): " + value +" ";
			notification = notification + '( <a href="'+ view_url + '" target="maparea">view</a> ) </div>';
	
			locater.UpdateResultDiv( notification );
			window.open(view_url,"maparea");
			
		});
		//$('#result_div').append(notification);
	}
	
	this.Locate = function ()
	{
		var vehicle_id = $('#vehicle_id').val();
		var notification = "<div>LOCATE request sent for vehicle "+ vehicle_id + "</div>";
		this.UpdateResultDiv( notification );
	}
	
	this.UpdateResultDiv = function( notification )
	{
		$('#result_div').html( notification + $('#result_div').html() );
	}

}
