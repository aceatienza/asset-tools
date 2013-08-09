@extends('layouts.cms_layout')

@section('content')
	{{ Form::model($user, array(
		'class' => 'node',
		'route' => array('control.user.update', $user->id)
	)) }}
		<ul>
			<li>
				{{ Form::label('username', 'Username') }}
				{{ Form::text('username') }}
			</li>
			<li>
				{{ Form::label('email', 'Email') }}
				{{ Form::text('email') }}
			</li>
			<li>
		        <h4>Role</h4>
		        @if($user->hasRole('User'))
		        	{{ Form::label('role', 'Admin') }}
		        	{{ Form::radio('role', 'Admin') }}
		        	{{ Form::label('role', 'User') }}
		        	{{ Form::radio('role', 'User', true) }}
	        	@else
	        		{{ Form::label('role', 'Admin') }}
		        	{{ Form::radio('role', 'Admin', true) }}
		        	{{ Form::label('role', 'User') }}
	        		{{ Form::radio('role', 'User') }}
		        @endif
			</li>
			<li>Set new password:</li>
			<li>
				{{ Form::label('Password') }}
				{{ Form::password('password') }}
			</li>
			<li>
				{{ Form::label('Password Confirmation') }}
				{{ Form::password('password_confirmation') }}
			</li>
			<li>
				{{ Form::submit('Update') }}
				{{ link_to_route('control.user.index', 'Cancel', array('class' => 'btn')) }}
			</li>

		</ul>
		
	{{ Form::close() }}
@stop