<!DOCTYPE HTML>
<!--
	Dimension by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>107學年-資料庫系統第12組專題</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('css/main.css')}}" />
		<noscript><link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('css/noscript.css')}}" /></noscript>
		<link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap" rel="stylesheet">
		<style> a, h1, h2, label[for], .inner, input[type]{font-family: 'Noto Sans TC', sans-serif;}</style>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="content">
							<div class="inner">
								<h1>專題進度看板</h1>
							</div>
						</div>
						<nav>
							<ul>
								<!--<li><a href="#intro">Intro</a></li>-->
								<!--<li><a href="#work">Work</a></li>-->
								<!--<li><a href="#about">About</a></li>-->
								<li><a href="#login">請點我</a></li>
								<!--<li><a href="#elements">Elements</a></li>-->
							</ul>
						</nav>
					</header>

				<!-- Main -->
					<div id="main">
						<!-- login -->
							<article id="login">
								<h2 class="major">107學年-資料庫系統第12組專題</h2>
								<form method="post" action="{{action('Controller@login')}}">
									@csrf
									<p style="background-color: #c51f1a;text-align: center">{{$message_login}}</p>
									<div class="fields">
										<div class="field half">
											<label for="user">帳號</label>
											<input type="text" name="user" required/>
										</div>
										<div class="field half">
											<label for="pass">密碼</label>
											<input type="password" name="pass" required/>
										</div>
									<div class="field half">
											<label for="auth">驗證碼</label>
											<input type="text" name="auth" required/>
										</div>
										<div class="field half"><br>
											<a href="{{url('/#login')}}" style="margin-top: 100px">
												<img src="{{$authcode}}"></a>
										</div>
									</div>
									<ul class="actions">
										<li><input type="submit" value="登入" class="primary" /></li>
										<li><input type="button" value="註冊" onClick="location.href='#signup'"></li>
									</ul>
								</form>
							</article>
						
						<!-- signup -->
						<article id="signup">
							<h2 class="major">註冊頁面</h2>
							<form method="post" action="{{url('/signup/')}}">
								@csrf
								<p style="background-color: #c51f1a;text-align: center">{{$message_signup}}</p>
								<div class="fields">
									<div class="field half">
										<label for="username">帳號(學號或教師編號)</label>
										<input type="text" name="user" required/>
									</div>
									<div class="field half">
										<label for="username">選擇身分</label>
										<input type="radio" id="demo-priority-low" name="priority" value="manager" checked>
										<label for="demo-priority-low">老師</label>
										<input type="radio" id="demo-priority-high" name="priority" value="users">
										<label for="demo-priority-high">學生</label>
									</div>
									<div class="field half">
										<label for="pass">密碼</label>
										<input type="password" name="pass" required/>
									</div>
									<div class="field half">
										<label for="pass2">確認密碼</label>
										<input type="password" name="pass2" required/>
									</div>
									<div class="field half">
											<label for="name">姓名</label>
											<input type="text" name="name" required/>
									</div>
									<div class="field half">
											<label for="tele">電話號碼</label>
											<input type="text" name="tel" required/>
									</div>
									<div class="field">
											<label for="ema">電子信箱</label>
											<input type="email" name="email" required/>
									</div>
								<div class="field half">
										<label for="authic">驗證碼</label>
										<input type="text" name="auth" required/>
									</div>
									<div class="field half"><br>
										<a href="{{url('/#login')}}" style="margin-top: 100px"><img src="{{$authcode}}"></a></a>
									</div>

								</div>
								<ul class="actions">
									<li><input type="submit" value="確認送出" class="primary" /></li>
								</ul>
							</form>
						</article>
					</div>

				<!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; Untitled. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
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

	</body>
</html>
