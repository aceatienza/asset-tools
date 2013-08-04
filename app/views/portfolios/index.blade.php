@extends('layouts.cms_layout')

@section('content')

    {{ link_to_route('control.portfolio.create', 'Create Portfolio') }}

    @if ($portfolios->count())
        <table class="groups">
            <tbody>
                @foreach ($portfolios as $portfolio)
                    <tr>
                    	<td><a href="" class="toggle">&nbsp</a></td>
                        <td>{{ link_to_route('control.portfolio.edit', $portfolio->client_name, array($portfolio->id), array('class' => 'btn btn-info')) }}</td>
                        <td>
                            {{ Form::open(array('method' => 'DELETE', 'route' => array('control.portfolio.destroy', $portfolio->id))) }}
                                {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        There are no portfolios 
    @endif
@stop