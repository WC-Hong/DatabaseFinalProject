@extends('web_template')

@section('title', '登出')

@section('home_title')
	<div class="inner">
		<h1>{{$message}}</h1>
	</div>
@endsection
@section('options')
	<ul>
		<li><a href="{{$back_url}}">{{$back}}</a></li>
	</ul>
@endsection
