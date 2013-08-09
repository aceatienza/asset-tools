@extends('layouts.cms_layout')

@section('content')

        {{ Form::open(array(
            'url' => 'control/edit',
            'class'  => 'node',
            'name'   => 'settings'
        )) }}
            <ul>
                @if(empty($currentSettings))
                        <li>
                            {{ Form::label('vimeo_key') }}
                            {{ Form::text('vimeo_key') }}
                        </li>    
                        <li>
                            {{ Form::label('vimeo_secret') }}
                            {{ Form::text('vimeo_secret') }}
                        </li> 
                @endif

                @foreach ($currentSettings as $k => $v)
                <li class="setting-item">
                           {{ Form::label($k) }}
                            {{ Form::text($k, $v)}}
                        <!-- TODO: change to a sprite, png, or data uri -->
                        <span class="delete-item"
                                data-url="{{ $deleteUrl }}"
                                data-name="{{ $k }}"
                                data-value="{{ $v }}">X
                        </span>
                </li>
                @endforeach

                <br>

                <fieldset>
                    <legend>
                        {{ link_to('#', 'Add: (Google Analytics, Twitter, Facebook, etc)', array('id' => 'new-service')) }} 
                    </legend>
                    <ul class="new-service">
                        <li>
                            {{ Form::label('service_name') }}
                            {{ Form::text('name') }}
                        </li>
                        <li>
                            {{ Form::label('service_value') }}
                            {{ Form::text('value') }}
                        </li>
                    </ul>
                </fieldset>

                @if ( Session::get('error') )
                    <div class="alert alert-error">{{{ Session::get('error') }}}</div>
                @endif

                @if ( Session::get('notice') )
                    <div class="alert">{{{ Session::get('notice') }}}</div>
                @endif
            <li>
            {{ Form::submit('Submit', array('class' => 'cms_submit_button') ) }}
            </li>    
            </ul>
        {{ Form::close() }}
@stop