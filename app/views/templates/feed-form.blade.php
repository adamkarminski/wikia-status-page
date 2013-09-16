{{ Form::open( array(
	'route' => "postMessage",
	'method' => 'post',
	'class' => 'form-inline'
	)) }}
{{ Form::token() }}
{{ Form::hidden( 'flag', 0 ) }}
<span class="col-8">
	{{ Form::text( 'message', NULL, array( 'placeholder' => 'Your message...', 'class' => 'form-control', 'maxlength' => '160' ) ) }}
</span>
<span class="col-2 btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" id="dropdown-button" data-toggle="dropdown">
	    No Flag <span class="caret"></span>
	</button>
	<ul class="dropdown-menu" id="flags-dropdown">
	  <li><a href="#" data-flag="0">No Flag</a></li>
	  <li><a href="#" data-flag="1">Success</a></li>
	  <li><a href="#" data-flag="2">Warning</a></li>
	  <li><a href="#" data-flag="3">Error</a></li>
	</ul>
	
</span>
<span class="col-2">
	{{ Form::button('Send', array( 'class' => 'btn btn-primary', 'type' => 'submit' ) ) }}
</span>
{{ Form::close() }}