@extends('layouts.master')

@section('content')
<div class="row">
	<div class="login-form col-6 col-offset-3">
		<h3>Log in to write on shoutbox</h3>
		{{ Form::open( array( 'url' => 'login' ) ) }}

			<!-- check for login errors flash var -->
			@if (Session::has('login_errors'))
			<div class="alert alert-danger">Username or password incorrect.</div>
			@endif
			
			<div class="form-group">
				<!-- username field -->
				{{ Form::label('username', 'Username') }}
				{{ Form::text('username', NULL, array( 'class' => 'form-control', 'placeholder' => 'Enter username...' ) ) }}
			</div>
			
			<div class="form-group">
				<!-- password field -->
				{{ Form::label('password', 'Password') }}
				{{ Form::password('password', array( 'class' => 'form-control', 'placeholder' => 'Enter password...' ) ) }}
			</div>	

			<!-- submit button -->
			{{ Form::submit('Login', array( 'class' => 'form-control btn btn-primary' )) }}

		{{ Form::close() }}
	</div>
</div>
@endsection