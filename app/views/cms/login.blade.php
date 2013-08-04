@extends('layouts.cms_layout')

@section('content')

    <h3>CMS Login</h3>

    <div class="signin_box">

        {{ Form::open(array('url' => 'control/login', 'method' => 'POST')) }}
            <div>
                {{ Form::label('email', 'Username or Email') }}
                {{ Form::text('email') }}
            </div>
            <div>
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password') }}
                <small>
                    <a href="{{{ (Confide::checkAction('UserController@forgot_password')) ?: 'forgot' }}}">
                        {{{ Lang::get('confide::confide.login.forgot_password') }}}
                    </a>
                </small>
            </div>

                @if ( Session::get('error') )
                    <div class="alert alert-error">{{{ Session::get('error') }}}</div>
                @endif

                @if ( Session::get('notice') )
                    <div class="alert">{{{ Session::get('notice') }}}</div>
                @endif

            {{ Form::submit('Login', array('class' => 'cms_login_button') ) }}

            <label for="remember" class="checkbox">{{{ Lang::get('confide::confide.login.remember') }}}
                <input type="hidden" name="remember" value="0">
                <input type="checkbox" name="remember" id="remember" value="1">
            </label>

        {{ Form::close() }}

    </div>
@stop