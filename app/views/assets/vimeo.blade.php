@extends('layouts.cms_layout')

@section('content')

<heading><h3>Select a Vimeo Video</h3></heading>

    <ul>
        @foreach($video_list as $id => $video)
            <li class="video_item">
                <!--<span class="video_title">{{$video['title']}}</span>-->
                <!--overlay or add title and info underneath-->

                <!-- old school! since we're not using javascript -->
                <a href="/control/asset/create/?id={{ $id }}&url={{ urlencode($video['url']) }}&thumb={{ urlencode($video['thumbnail']) }}"
                    title="{{ $video['title'] }}"
                >
                    <img src="{{ $video['thumbnail'] }}">
                </a>
            </li>
            
        @endforeach

        <!-- TODO: show next page of videos -->

    </ul>

@stop


