@extends('layouts.cms_layout')

@section('content')

    <h3>Settings</h3>

    <div class="">

        {{ Form::open($form_opts) }}
            @if(empty($currentSettings))
                <ul>
                
                    <li>
                        {{ Form::label('vimeo_key') }}
                        {{ Form::text('vimeo_key') }}
                    </li>    
                    <li>
                        {{ Form::label('vimeo_secret') }}
                        {{ Form::text('vimeo_secret') }}
                    </li> 

                </ul>
            @endif
            
            <ul>
                @foreach ($currentSettings as $k => $v)
                    <div class="setting-item">
                        <li>        
                            {{ Form::label($k) }}
                            {{ Form::text($k, $v)}}
                        </li>
                        <span class="delete-item hide"
                                data-url="{{ $deleteUrl }}"
                                data-name="{{ $k }}"
                                data-value="{{ $v }}">X
                        </span>
                    </div>
                @endforeach
            </ul>

            <!-- css start off as display:none; js to toggle open -->
            <br>
            Add a new service (Google Analytics, Twitter, Facebook, etc)
            <ul>
                <li>
                    {{ Form::label('service_name') }}
                    {{ Form::text('name') }}
                </li>
                <li>
                    {{ Form::label('service_value') }}
                    {{ Form::text('value') }}
                </li>
            </ul>

                @if ( Session::get('error') )
                    <div class="alert alert-error">{{{ Session::get('error') }}}</div>
                @endif

                @if ( Session::get('notice') )
                    <div class="alert">{{{ Session::get('notice') }}}</div>
                @endif

            {{ Form::submit('Submit', array('class' => 'cms_submit_button') ) }}
        {{ Form::close() }}

    </div>
@stop