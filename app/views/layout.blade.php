<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title></title>
    {{ stylesheet() }}
     <!-- scripts.min.js -->
    {{ script() }} 
</head>
<body>
	<header id="site-header">
		<div class="container">
			<a href="/" class="history-api" data-alias="/">
				<img src="/images/logo_2column.png" id="bf_logo">
			</a>
			<nav id="primary-navigation" class="fade">
				<!-- home link points to / -->
				<!-- logged in as -->

				<a href="http://www.brooklynfoundry.com/our-work" class="history-api" data-alias="our-work">Our Work</a>
				<a href="http://www.brooklynfoundry.com/about" class="history-api" data-alias="about">About</a>
				<a href="http://www.brooklynfoundry.com/client-list" class="history-api" data-alias="client-list">Client List</a>
				<a href="http://www.brooklynfoundry.com/contact" class="history-api" data-alias="contact">Contact</a>
			</nav>
		</div>
	</header>

    <div id="container">
        @yield('content')
    </div>
</body>
</html>