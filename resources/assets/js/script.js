$(document).ready(function(){

	$('.pay-bill').click(function(e){
		e.preventDefault();	
		var url = $(this).attr('href');
		var entryId = $(this).data('entry-id');
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
				//get table row
				var tr = $('table').find("[data-entry='"+entryId+"']");

				tr.find('.balance').html(data.balance);
				tr.find('.paid').html(data.paid);
				$('#payment-modal-'+entryId).modal('toggle');
			},
			error: function(data) {
				console.log(data);
			}
		})
	})
});