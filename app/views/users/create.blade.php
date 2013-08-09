@extends('layouts.cms_layout')

@section('content')

	<form class="node" 
			ethod="POST" 
			action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" 
			accept-charset="UTF-8"
			autocomplete="off"
	>
	    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
	    <fieldset>
	    	<legend>Create New User</legend>
	    	<ul>
	    		<li>
	        		<label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
	        		<input placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
	        	</li>
	        	<li>
	        		<label for="email">{{{ Lang::get('confide::confide.e_mail') }}} </label>
	        		<input placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        		</li>
     			<li>
			        <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
	    		    <input placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
				</li>
				<li>
	        		<label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
	        		<input placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        		</li>

       			<li>
        			<fieldset class="role">
        				<span>Role</span>
        				<legend></legend>
		        			{{ Form::label('role', 'Admin') }}
		        			{{ Form::radio('role', 'Admin') }}
		        			{{ Form::label('role', 'User') }}
		        			{{ Form::radio('role', 'User', true) }}
    				</fieldset>
				</li>

			

	        @if ( Session::get('error') )
	            <div class="alert alert-error">
	                @if ( is_array(Session::get('error')) )
	                    {{ head(Session::get('error')) }}
	                @endif
	            </div>
	        @endif

	        @if ( Session::get('notice') )
	            <div class="alert">{{ Session::get('notice') }}</div>
	        @endif
	        <li>
	     	    <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
	          	{{ link_to_route('control.user.index', 'Cancel', array('class' => 'btn')) }}
          	</li>
	        </ul>  
	    </fieldset>
	</form>

@stop


