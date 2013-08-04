@extends('layouts.cms_layout')

@section('content')
	{{ link_to('control/user/create', 'Create User') }}

	<div class="groups">
		<ul class="users">
		    @foreach ($users as $user)
				<li class="item">
					<a href="" class="toggle">&nbsp</a>
					<a href="{{ URL::to('control/user/' . $user->id) }}"> {{ $user->username }} </a>        
			    </li>
		    @endforeach
		</ul>
	</div>
@stop