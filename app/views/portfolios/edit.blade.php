@extends('layouts.cms_layout')

@section('content')

{{ Form::model($portfolio, array('method' => 'PATCH', 'route' => array('control.portfolio.update', $portfolio->id))) }}
    <ul>
        <li>
            {{ Form::label('client_name', 'Name:') }}
            {{ Form::text('client_name') }}
        </li>

        <div>Add ability to choose Feature Image/Video</div>

        <div>Add ability to order Assets</div>

        <h3>Assets</h3>
        <div class="asset_list">
            @foreach ($portfolio->assets as $asset)
                <div class="asset">
                    <h4>{{ link_to_route('control.asset.edit', $asset->name, array($asset->id), array('class' => '')) }}</h4>
                    <img src="{{ $asset->path }}">
                </div>
            @endforeach
        </div>       

        <div>
        -- Add more Assets to this portfolio --
        // pull in the first 10? assets into the first page, assets as thumbnails, add class to hide or display:none to begin
        // then a never ending scroll until last is loaded; blur out the bottom of the page to indicate more or use an arrow downwards
        // control/portfolio/id/edit/assets
        <ol> // to be able to sort later
            @foreach ($assets as $asset)
                <li data-item-id="">
                    <img src="#thumbpath">
                    <span class=""><time>{age since added}</time></span>
                    <span class="add_ico">+</span> <!-- clicking this should add it to above -->
                </li>
            @endforeach
        </ol>
        </div>

        @if(isset($portfolio->path))
            <li>
                <img src="{{ $portfolio->path }}" alt="">
            </li>
        @endif
        <li>
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('control', 'Cancel', array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

        {{ Form::open(array('method' => 'DELETE', 'route' => array('control.portfolio.destroy', $portfolio->id))) }}
            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
        {{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop