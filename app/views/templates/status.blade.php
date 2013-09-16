@extends('layouts.master')

@section('content')

<!-- User Friendly Info -->
<div class="row" id="main-info-container">
	<div class="main-info alert alert-success" id="main-info-success">All systems are fine!</div>
	<div class="main-info alert" id="main-info-warning">You may experience some issues!</div>
	<div class="main-info alert alert-danger" id="main-info-danger">We are sorry but we are down!</div>
	
</div>

<!-- Feed -->
<div class="row">
	<h3>From Administrators</h3>
	<div class="feed col-12">
		<div id="display" class="col-12">
			@if ( Auth::check() === true )
				@include('templates.feed-auth')
			@else
				@include('templates.feed')
			@endif
		</div>
		<div id="form" class="col-12">
			@if ( Auth::check() === true )
				@include('templates.feed-form')
			@endif
		</div>
	</div>
</div>

<div class="row">
	<h3>Detailed information</h3>
	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title">Servers</h3>
		</div>
		<table class="table" id="fastly">
			<tr>
				<th class="col-10">Name</th>
				<th class="col-2">Status</th>
			</tr>
			<tr>
				<td class="col-10">Last 30 days average uptime</td>
				<td class="col-2" id="pingdom-uptime">{{ HTML::image('img/preloader.gif') }}</td>
			</tr>
		</table>
	</div>

	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title">Services</h3>
		</div>
		<table class="table">
			<tr>
				<th class="col-10">Service name</th>
				<th class="col-2">Status</th>
			</tr>
			<tr>
				<td class="col-10">Web server</td>
				<td class="col-2" id="nagios-Apache_Cluster">{{ HTML::image('img/preloader.gif') }}</td>
			</tr>
			<tr>
				<td class="col-10">Thumbnailer</td>
				<td class="col-2" id="nagios-Thumbnailers_Cluster">{{ HTML::image('img/preloader.gif') }}</td>
			</tr>
			<tr>
				<td class="col-10">Database writability</td>
				<td class="col-2" id="nagios-DB_Clusters">{{ HTML::image('img/preloader.gif') }}</td>
			</tr>
		</table>
	</div>


</div>

<div class="row">
	<div class="col-6">
		<h3>About this site</h3>
		@include('templates.message')
	</div>
	<div class="col-6">
		<h3>Wikia twitter feed</h3>
		<a class="twitter-timeline .hidden-sm" height="300" href="https://twitter.com/Wikia" data-widget-id="362570884822753280">Tweets by @Wikia</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
</div>
@endsection