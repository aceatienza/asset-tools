@extends('layouts.cms_layout')

@section('content')

{{ Form::open(array(
                'url' => 'control/asset',
                'class'  => 'node',
                'name'   => 'newAsset',
                'files'  => true
        )) }}
    <input id="vimeo_id" name="vimeo_id" type="hidden" value="">
    <input id="vimeo_title" name="vimeo_title" type="hidden" value="">
    <input id="vimeo_url" name="vimeo_url" type="hidden" value="">
    <input id="vimeo_thumbnail" name="vimeo_thumbnail" type="hidden" value="">
    <fieldset>
        <legend>Add Asset</legend>
        <ul>
            <li>
                {{ Form::label('name', 'Name:') }}
                {{ Form::text('name') }}
            </li>
            <li>
                <div class="dropzoneContainer">
                    <div class="dropzone">Dropzone</div>
                    <p>{{ Form::file('image', array('id' => 'fileupload')) }}</p>    
                </div>
            </li>

            <!-- <span>Drop a video, click to upload, or select a Vimeo video below</span>  -->
            <li>
                {{ Form::submit('Submit', array('class' => 'btn')) }}
                {{ link_to_route('control.asset.index', 'Cancel', array('class' => 'btn')) }}
            </li>
        </ul>
    </fieldset>        
{{ Form::close() }}

<header><h3>Vimeo Videos</h3></header>
@foreach($video_list as $id => $video)
    <li data-item-id="{{ $id }}" 
        data-url="{{ $video['url'] }}"
        data-thumb="{{ $video['thumbnail'] }}" 
        class="video_item" title="{{ $video['title'] }}">
        <!--<span class="video_title">{{$video['title']}}</span>-->
        <!--overlay or add underneath-->
        <img src="{{ $video['thumbnail'] }}">
    </li>
@endforeach





@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop


