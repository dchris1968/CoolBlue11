$(document).ready(function(){

	$.getJSON("http://localhost/BasicWebService/carwebservice.php", function(data) {
		$.each(data, function(i, item){
			var table_row = $("<tr>").appendTo("#dataTable");
			$("<td>").text(item.id).appendTo(table_row);
			$("<td>").text(item.year).appendTo(table_row);
			$("<td>").text(item.make).appendTo(table_row);
			$("<td>").text(item.model).appendTo(table_row);
			$("<td>").text(item.color).appendTo(table_row);
		});
	});	
	
});