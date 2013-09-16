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

	// Delete message

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

	/*
	* External APIs calls
	*/

	// Pingdom call

	$.ajax({
		type: "GET",
		url: "http://localhost/wikia/status/public/api/pingdom",
		dataType: "json"
		})
	.done( function( resp ) {

		if ( resp[ 'uptime' ] == 'Not available' ) {
			sUptimeClass = "muted";
		} else {
			sUptimeClass = "text-success";
		}

		$( '#pingdom-uptime' ).html( '<span class="' + sUptimeClass + '">' + resp[ 'uptime' ] + '</span>' );
	}),

	// Nagios call

	$.ajax({
		type: "GET",
		url: "http://localhost/wikia/status/public/api/nagiostest",
		dataType: "json"
	})
	.done( function( resp ) {
		var iWarnings = 0, iErrors = 0, iClusters = 0, iClustersDown = 0;
		$.each ( resp, function ( key, object ) {

			reOK = new RegExp('OK:');
			reDBCluster = new RegExp('Cluster[0-9]+');

			if ( object.host_name == "Apache_Cluster" ) {
				if ( !reOK.test( object.plugin_output ) ) {
					++iErrors;
					showNagiosStats( object.host_name, "Down" );
				} else {
					showNagiosStats( object.host_name, "OK" );
				}
			}
			else if ( object.host_name == "Thumbnailers_Cluster" ) {
				if ( !reOK.test( object.plugin_output ) ) {
					++iWarnings;
					showNagiosStats( object.host_name, "Down" );
				} else {
					showNagiosStats( object.host_name, "OK" );
				}
			}
			else if ( reDBCluster.test( object.service_description ) ) {
				if ( !reOK.test( object.plugin_output ) ) {
					++iClustersDown;
					++iClusters;
				} else {
					++iClusters;
				}
			}

		});

		if ( iClustersDown > 0 ) {
			if ( iClustersDown == iClusters ) {
				showNagiosStats( 'DB_Clusters', "Down" );
				++iWarnings;
			} else {
				showNagiosStats( 'DB_Clusters', "Some issues" );
				++iWarnings;
			}
		} else {
			showNagiosStats( 'DB_Clusters', "OK" );
		}
		
		$( "div#main-info-container" ).show();

		if ( iErrors > 0 ) {
			$( "div#main-info-danger" ).show();
		} else if ( iWarnings > 0 ) {
			$( "div#main-info-warning" ).show();
		} else {
			$( "div#main-info-success" ).show();
		}

	})

});

function showNagiosStats( sService, sStatus ) {

	var sStatusClass = "";

	if ( sStatus == "OK" ) {
		sStatusClass = "success";
	} else if ( sStatus == "Some issues" ) {
		sStatusClass = "warning";
	} else {
		sStatusClass = "danger"
	}

	$( '#nagios-' + sService ).html( '<span class="text-' + sStatusClass + '">'+ sStatus +'</span>' );
}