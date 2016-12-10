$(document).ready(function(){

	$('#pay-bill').click(function(e){
		e.preventDefault();
		
		var url = $(this).attr('href');
		var csrfToken = $(this).data('token');

		$.ajax({
			url: url,
			method: "PATCH",
			headers: {
				'X-CSRF-TOKEN': csrfToken
			},
			data: {
				pay: true
			},
			success: function(data) {
				console.log(data);
			},
			error: function(data) {
				console.log(data);
			}
		})
	})
});