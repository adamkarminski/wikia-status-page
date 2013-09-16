@foreach ( Message::indexMessage() as $message )
	<div class="message col-12 flag-{{ $message->flag }}" id="message-{{ $message->id }}">
		<div class="message-text col-9">
			@if( $message->flag == 1 )
				<span class="glyphicon glyphicon-check"></span>
			@elseif( $message->flag == 2 )
				<span class="glyphicon glyphicon-warning-sign"></span>
			@elseif( $message->flag == 3 )
				<span class="glyphicon glyphicon-remove"></span>
			@endif
			{{ $message->message }}
		</div>
		<div class="message-date col-3">
			<?php // DateTime::createFromFormat('j W, H:m',$message->created_at) ?>
			{{ date('H:m:s, F j', $message->created_at->__get('timestamp')) }}
		</div>
	</div>
@endforeach
