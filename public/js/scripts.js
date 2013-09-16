$(document).ready(function() {

	/*
	*** MESSAGES ***
	*/

	// Set flag

	$( 'ul#flags-dropdown > li > a' ).bind( 'click', function() {

		// Define dropdown button labels and classes

		var aMessageLabels = [ 'No Flag', 'Success', 'Warning', 'Error' ];
		var aMessageClasses = [ 'default', 'success', 'warning', 'danger' ];

		// Get old and new flag

		var iNewFlag = $( this ).data( 'flag' );
		var iOldFlag = $( 'input[name=flag]' ).val();
		
		// Change dropdown button

		$( '#dropdown-button' )
		.removeClass( 'btn-' + aMessageClasses[ iOldFlag ] )
		.addClass( 'btn-' + aMessageClasses[ iNewFlag ] )
		.html( aMessageLabels[ iNewFlag ] + ' <span class="caret"></span>' );

		// Change hidden input[name=flag] value
		$( 'input[name=flag]' ).val( iNewFlag );


	});

	

	// Deletion

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