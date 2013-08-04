@extends('layouts.cms_layout')

@section('content')

<h3>Add Asset</h3>

{{ Form::open($form_opts) }}
    <ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <!-- add file upload -->
        <li>
            {{ Form::file('image', array('id' => 'fileupload')) }}
        </li>
<!--         <h3>Portfolios</h3>
        <li>
            <span>Add to portfolio</span>
            {{ Form::select('Portfolios', $portfolio_list) }}
        </li> -->
        // Drop a video, click to upload, or select a Vimeo video below
        <input id="vimeo_id" name="vimeo_id" type="hidden" value="">
        <input id="vimeo_title" name="vimeo_title" type="hidden" value="">
        <input id="vimeo_url" name="vimeo_url" type="hidden" value="">
        <input id="vimeo_thumbnail" name="vimeo_thumbnail" type="hidden" value="">
        <!-- use javascript to update the value of the input above -->

        <heading><h3>Vimeo Videos</h3></heading>
        @foreach($video_list as $id => $video)
            <li data-item-id="{{ $id }}" class="video_item" title="{{ $video['title'] }}">
                <!--<span class="video_title">{{$video['title']}}</span>-->
                <!--overlay or add underneath-->
                <img src="{{ $video['thumbnail'] }}">
            </li>
            
        @endforeach

        <li>
            {{ Form::submit('Submit', array('class' => 'btn')) }}
            {{ link_to_route('control.asset.index', 'Cancel', array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop


