@extends('layouts.cms_layout')

@section('content')
<ul>
	{{ Form::open(array('url' => 'control/portfolio')) }}
	<li>
		{{ Form::label('Client Name') }}
	 	{{ Form::text('client_name') }}	
 	</li>
	<li>
		{{ Form::label('Description') }}
	 	{{ Form::text('description') }}
 	</li>
	<li>
		Date: <input id="date" type="date" min="1900-01-01" name="date">
	</li>
	<li>
		Url: <input id="url" name="url" type="text">
	</li>
	<li>
	 	{{ Form::submit('Submit') }}
	 	{{ link_to_route('control.portfolio.index', 'Cancel', array('class' => 'btn')) }}
 	</li>
	{{ Form::close() }}
</ul>
@stop