<!DOCTYPE HTML>
<html>
<head>
	{{ stylesheet('cms_style.css') }}
</head>
<body>
	<div id="container">

		@if(Auth::check())
			<header class="mainHeader">
				<nav class="mainNav">
					<ul>
						<a href="{{ URL::to('control') }}">
							<li {{ Request::is('control') ? 'class="active"':'' }} >Home</li>
						</a>
						<a href="{{ URL::to('control/portfolio') }}">
							<li {{ Request::is('control/portfolio*') ? 'class="active"':'' }} >Portfolio</li>
						</a>
						<a href="{{ URL::to('control/asset') }}">
							<li {{ Request::is('control/asset*') ? 'class="active"':'' }} >Assets</li>
						</a>
						<a href="{{ URL::to('control/user') }}">
							<li {{ Request::is('control/user*') ? 'class="active"':'' }} >Users</li>
						</a>
					</ul>
				</nav>


			</header>

			<div id="logout">
				{{ HTML::link('control/edit', 'Settings', array(
					'id' => 'settings'))}}
				{{ link_to_route('logout', 'Logout') }}
			</div>
		@endif

		@yield('content')

	</div>
	
	<!-- Load our precious javascript -->
	<script data-main="/js/main.js" src="/js/require.js"></script>
</body>
</html>