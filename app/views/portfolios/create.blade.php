@extends('layouts.cms_layout')

@section('content')

	{{ Form::open(array('class' => 'node', 'url' => 'control/portfolio')) }}
	<fieldset>
		<ul>
			<li>
				{{ Form::label('Client Name') }}
			 	{{ Form::text('client_name') }}	
		 	</li>
			<li>
				{{ Form::label('Description') }}
			 	{{ Form::text('description') }}
		 	</li>
			<li>
				{{ Form::label('Date') }}
				<input id="date" type="date" min="1900-01-01" name="date">
			</li>
			<li>
				{{ Form::label('Url') }}
				<input id="url" name="url" type="text">
			</li>
			<li>
			 	{{ Form::submit('Submit') }}
			 	{{ link_to_route('control.portfolio.index', 'Cancel', array('class' => 'btn')) }}
		 	</li>
	 	</ul>
 	</fieldset>
	{{ Form::close() }}

@stop