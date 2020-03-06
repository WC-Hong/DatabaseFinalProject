@extends('web_template')

@section('title', '')

@section('home_title')
	<div class="inner">
		<h1>專題進度看板</h1>
	</div>
@endsection
@section('options')
	<ul>
		<li><a href="#login">請點我</a></li>
	</ul>
@endsection

@section('body')
	<article id="login">
		<h2 class="major">107學年-資料庫系統第12組專題</h2>
		<div id="login_message" style="background-color: #c51f1a;color: white;text-align: center"></div>
		<form autocomplete="off" novalidate="" name="login">
			@csrf
			<div class="fields">
				<div class="field half">
					<label for="user">帳號</label>
					<input type="text" name="user" id="login_user" required="required"/>
				</div>
				<div class="field half">
					<label for="pass">密碼</label>
					<input type="password" name="pass" id="login_pass" required/>
				</div>
				<div class="field half">
					<label for="auth">驗證碼</label>
					<input type="text" name="auth" id="login_auth" required/>
				</div>
				<div class="field half"><br>
					<a href="#login" style="margin-top: 100px">
						<img id="login_auth_image" onclick="change_auth()" src="{{$authcode}}">
					</a>
				</div>
			</div>
			<ul class="actions">
				<li><input type="button" value="登入" onClick="login_to('{{url('/login/')}}');" class="primary" /></li>
				<li><input type="button" value="註冊" onClick="location.href='#register'"></li>
			</ul>
		</form>
	</article>

	<!-- registered -->
	<article id="register">
		<h2 class="major">註冊頁面</h2>
		<div id="register_message" style="background-color: #c51f1a;color: white;text-align: center"></div>
		<form autocomplete="off" novalidate="">
			@csrf
			<p style="background-color: #c51f1a;text-align: center">{{$message_signup}}</p>
			<div class="fields">
				<div class="field half">
					<label for="username">帳號(學號或教師編號)</label>
					<input type="text" name="user" id="register_user" required/>
				</div>
				<div class="field half">
					<label for="username">選擇身分</label>
					<input type="radio" id="demo-priority-low" name="identity" value="manager" checked>
					<label for="demo-priority-low">老師</label>
					<input type="radio" id="demo-priority-high" name="identity" value="users">
					<label for="demo-priority-high">學生</label>
				</div>
				<div class="field half">
					<label for="pass">密碼</label>
					<input type="password" id="register_pass" name="pass" required/>
				</div>
				<div class="field half">
					<label for="pass2">確認密碼</label>
					<input type="password" id="register_pass2" name="pass2" required/>
				</div>
				<div class="field half">
						<label for="name">姓名</label>
						<input type="text" id="register_name" name="name" required/>
				</div>
				<div class="field half">
						<label for="tele">電話號碼</label>
						<input type="text" id="register_tel" name="tel" required/>
				</div>
				<div class="field">
						<label for="ema">電子信箱</label>
						<input type="email" id="register_email" name="email" required/>
				</div>
			<div class="field half">
					<label for="authic">驗證碼</label>
					<input type="text" id="register_auth" id="register_auth" name="auth" required/>
				</div>
				<div class="field half"><br>
					<a href="#register" style="margin-top: 100px">
						<img id="register_auth_image" onclick="change_auth()" src="{{$authcode}}">
					</a>
				</div>

			</div>
			<ul class="actions">
				<li><input type="button" onclick="register_to('{{url('/register/')}}');" value="確認送出" class="primary" /></li>
				<li><input type="button" onclick="location.href='#login'" value="返回登入頁面" /></li>
			</ul>
		</form>
	</article>
@endsection