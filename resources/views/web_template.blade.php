<!DOCTYPE HTML>
<!--
	Dimension by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>專題進度看板-@yield('title')</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('css/main.css')}}" />
		<link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('css/frappe-gantt.css')}}" />
		<script src="{{\Illuminate\Support\Facades\URL::asset('js/frappe-gantt.js')}}"></script>
		<noscript><link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('css/noscript.css')}}" /></noscript>
		<link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC:300,400,500&display=swap" rel="stylesheet">
		<style> li, a, p, h1, h2, h3, h4, label[for], .inner, input[type]{font-family: 'Noto Sans TC', sans-serif;}</style>
	</head>
	<body class="is-preload">
		<!-- Wrapper -->
		<div id="wrapper">
			<!-- Header -->
			<header id="header">
				<div class="content">
					@yield('home_title')
				</div>
				<nav>
					@yield('options')
				</nav>
			</header>

			<!-- Main -->
			<div id="main">
				@yield('body')
			</div>

			<!-- Footer -->
			<footer id="footer">
				<p class="copyright">&copy; Untitled. Design: <a href="http://csie.nfu.edu.tw/zh/">NFU CSIE</a>.</p>
			</footer>
		</div>

		<!-- BG -->
		<div id="bg"></div>

		<!-- Scripts -->
		<script src="{{\Illuminate\Support\Facades\URL::asset('js/jquery.min.js')}}"></script>
		<script src="{{\Illuminate\Support\Facades\URL::asset('js/browser.min.js')}}"></script>
		<script src="{{\Illuminate\Support\Facades\URL::asset('js/breakpoints.min.js')}}"></script>
		<script src="{{\Illuminate\Support\Facades\URL::asset('js/util.js')}}"></script>
		<script src="{{\Illuminate\Support\Facades\URL::asset('js/main.js')}}"></script>
		<script src="{{\Illuminate\Support\Facades\URL::asset('js/myJS.js')}}"></script>
	</body>
</html>
