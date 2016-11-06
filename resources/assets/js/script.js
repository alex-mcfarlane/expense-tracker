$(document).ready(function(){
	$('#pay-bill').click(function(e){
		e.preventDefault();
		var url = $(this).attr('href');

		$.ajax({
			url: url,
			method: "POST",
			contentType: "application/json; charset=utf-8",
			success: function(data) {
				console.log(data);
			},
			error: function(data) {
				console.log(data);
			}
		})
	})
});