$(document).ready(function() {

	$( '.message-delete' ).bind( 'click', function() {

		var iMessageID = $( this ).data( 'id' );
		var oAjax = $.ajax({
			type: "DELETE",
			url: "http://localhost/wikia/status/public/message/delete",
			data: {
				id: iMessageID
			}
		})
		.done( function( resp ) {
			var iMessageID = resp['id'];
			$( "#message-" + iMessageID ).remove();
		});

	});

	

});