@extends('layouts.cms_layout')

@section('content')
    <section id="container_assets">
        {{ link_to_route('control.asset.create', 'Add Asset') }}

        @if ($assets->count())
            <table class="groups">
                <tbody>
                    @foreach ($assets as $asset)
                        <tr>
                            <td><a href="" class="toggle">&nbsp</a></td>
                            <td>{{ link_to_route('control.asset.edit', $asset->name, array($asset->id), array('class' => 'btn btn-info')) }}</td>
                            <td>{{{ $asset->filetype }}}</td>
                            <td>
                                {{ Form::open(array('method' => 'DELETE', 'route' => array('control.asset.destroy', $asset->id))) }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            There are no assets
        @endif
    </section>
@stop