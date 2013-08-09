@extends('layouts.cms_layout')

@section('content')

{{ Form::model($asset, array('method' => 'PATCH', 'class' => 'node', 'route' => array('control.asset.update', $asset->id))) }}
    <ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            @include('assets.asset')
        </li>

        <h3>Is in these portfolios...</h3>
        @foreach ($asset->portfolios as $portfolio)
            <h4>
                {{ $portfolio->client_name }}                
            </h4>
        @endforeach
        <li>
            <span>Add to portfolio</span>
            {{ Form::select('Portfolios', $portfolio_list) }}
        </li>
        <li>
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('control.asset.index', 'Cancel', array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

{{ Form::open(array('method' => 'DELETE', 'class' => 'node', 'route' => array('control.asset.destroy', $asset->id))) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop