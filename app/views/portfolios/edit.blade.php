@extends('layouts.cms_layout')

@section('content')

    {{ Form::model($portfolio, array(
        'class'     => 'node',
        'method'    => 'PUT',
        'route'     => array('control.portfolio.update', $portfolio->id)
    )) }}

    <input name="asset_ids[]" type="hidden" value="">

        <ul>
            <li>
                {{ Form::label('client_name', 'Name:') }}
                {{ Form::text('client_name') }}
            </li>

            <!-- TODO: Add ability to choose Feature Image/Video -->
            <!-- TODO: Order Assets in Portfolio by -->

            <span>Has these Assets...</span>
            <ul class="assetsInPortfolio">
                @foreach ($portfolio->assets as $asset)
                <li class="assetItem" data-item-id="{{ $asset->id }}">
                    <input name="asset_ids[]" type="hidden" value="{{ $asset->id }}">                  
                    @include('assets.asset')
                    <span class="delete-item">X</span>
                </li>
                @endforeach
            </ul>

            <!-- WORKS: TODO: hide this initially, only for non-js -->
            <!-- <li> -->
                <!-- <span>Add an asset</span> -->
                 <!-- {{ Form::select('assetlist', $assetlist) }} -->
            <!-- </li> -->

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

    <header><h3>Add more Assets</h3></header>
    <div class="assetList">

        <!-- TODO: ability to sort assets -->
        <ol> 
            @foreach ($assets as $asset)
                @foreach ($portfolio->assets as $assetInPortfolio)
                    <!-- Don't include assets already in this Portfolio -->
                    @if($asset->id != $assetInPortfolio->id)
                        <li class="assetItem" data-item-id="{{ $asset->id }}">
                            <!-- TODO: Add data- info to be able to add to portfolio with JS -->
                            @include('assets.asset')
                        </li>
                        
                    @endif
                @endforeach
            @endforeach
        </ol>
    </div>

@stop

