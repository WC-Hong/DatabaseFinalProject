@extends('web_template')

@section('title', '學生首頁')

@section('home_title')
	<div class="inner">
		<h1>歡迎，{{$name}}</h1>
		<p>沒有早一步<br>也沒有晚一步<br>最美好的一切都在剛剛好</p>
	</div>
@endsection

@section('options')
	<ul>
		<li><a href="#fill_in_Cal">查詢</a></li>
		<li><a href="#Gant">甘特圖</a></li>
		<li><a href="#fillin">填寫</a></li>
		<li><a href="#option">選項</a></li>
	</ul>
@endsection

@section('body')
	<!-- fill in Cal -->
	<article id="fill_in_Cal">
		<h2 class="major">查詢進度</h2>
		<div id="date_fill_message" style="background-color: #c51f1a;color: white;text-align: center"></div>
		<form method="post" action="#">
			<div class="fields">
				<div class="field">
					<label for="demo-category">專題組別</label>
					<select name="demo-category" id="demo-category">
						<option value="">----------------------------</option>
						@foreach($groups as $group)
							<option value="{{$group->projectname}}">{{$group->projectname}}</option>
						@endforeach
					</select>
				</div>
				<div class="field">
					<label for="demo-category">日期</label>
					<input type="date"name="upload_date" id="upload_date" hidden/>
				</div>
			</div>
			<ul class="actions">
				<li><input type="button" value="查詢" class="primary" onclick="student_calendar_research('{{url('/stu/search/')}}')"/></li>
			</ul>
		</form>
	</article>

	<!-- display_progress -->
	<article id="display_progress">
		<h2 class="major">顯示進度</h2>
		<div class="field">
			<label for="lastweek">上週填寫的下周報告項目</label>
			<input type="text" name="lastweek" id="search_last_week" readonly />
			<br>
		</div>
		<form method="post" action="#">
			<div class="fields">
				<div class="field">
					<label for="thisweek">本周專題報告的項目</label>
					<input type="text" name="thisweek" id="search_this_week" readonly />
				</div>
				<div class="field">
					<label for="nextweek">下周工作項目</label>
					<input type="text" name="nextweek" id="search_next_week" readonly />
				</div>
				<div class="field">
					<label for="nextweek">上週上傳檔案</label>
					<ul id="download_item">

					</ul>
				</div>
			</div>
			<ul class="actions">
				<li><input type="button" class="primary" value="繼續查詢" onclick="location.href='#fill_in_Cal'"></li>
			</ul>
		</form>
	</article>

	<!-- fill in -->
	<article id="fillin">
		<h2 class="major">填寫項目</h2>
		<div id="upload_message" style="background-color: #c51f1a;color: white;text-align: center"></div>
		<form method="post" action="#">
			<div class="fields">
				<div class="field">
					<label for="thisweek">本周專題報告的項目</label>
					<input type="text" name="thisweek" id="insert_this_week"/>
				</div>
				<div class="field">
					<label for="nextweek">下周工作項目</label>
					<input type="text" name="nextweek" id="insert_next_week"/>
				</div>
			</div>
			<div id="test"></div>
			<ul class="actions">
				<input type="file" name="upfile" id="upload"/>
				<li><input type="button" value="確認送出" class="primary" onclick="upload_work_item('{{url('/stu/upload/')}}')" /></li>
				<li><input type="button" value="上傳檔案" onclick="upload.click();document.getElementById('test').innerText='檔案路徑:'+upload.value;"/></li>
				<label for="test" id="test"></label>
			</ul>
		</form>
	</article>

	<article id="upload_complete">
		<h2 class="major">上傳完畢</h2>
	</article>

	<!-- Gant -->
	<article id="Gant">
		<h2 class="major">甘特圖</h2>
		<div id="student_gant_message" style="background-color: #c51f1a;color: white;text-align: center;"></div>
		<form method="post" action="#">
			<div class="fields">
				<div class="field">
					<label for="demo-category">專題</label>
					<select name="demo-category" id="student_gant_search_gantt" onchange="student_search_gantt('{{url('/stu/gantt/search/')}}');">
						<option value="">----------------------------</option>
						@foreach($groups as $group)
							<option value="{{$group->teamID}}">{{$group->projectname}}</option>
						@endforeach
					</select>
				</div>
				<div class="field">
					<div id="gantt"></div>
					<script id="student_gant_show_gantt"></script>
				</div>
			</div>
			<div class="field">
				<ul class="actions">
					<li><input type="button" value="修改" class="primary" onclick="student_list_gantt('{{url('/')}}');location.href='#modify_gantt';" /></li>
				</ul>
			</div>
		</form>
	</article>

	<!-- modify_gantt -->
	<article id="modify_gantt">
		<h2 class="major">甘特圖</h2>
		<div id="student_modify_gantt_message" style="background-color: #c51f1a;color: white;text-align: center;"></div>
		<div class="fields">
			<div class="table-wrapper">
				<table class="alt">
					<thead>
						<tr>
							<th style="width: 400px">工作名稱</th>
							<th>起始日期</th>
							<th>終止日期</th>
							<th style="width: 100px">操作</th>
						</tr>
					</thead>
					<tbody id="student_modify_gantt_modify_work_list">

					</tbody>
				</table>
			</div>
			<hr>
			<form>
				<div class="fields">
					<div class="field">
						<label for="name">工作項目</label>
						<input type="text" id="student_modify_gantt_content" />
					</div>
					<div class="field half">
						<label for="name">起始日期</label>
						<input type="date" id="student_modify_gantt_start" />
					</div>
					<div class="field half">
						<label for="name">結束日期</label>
						<input type="date" id="student_modify_gantt_end" />
					</div>
				</div>
				<input type="button" value="送出" class="primary" onclick="student_modify_gantt('{{url('/stu/gantt/modify/')}}', 'add')" />
				<input type="button" value="檢視" onclick="location.href='#Gant';" style="margin-left: 30px"/>
			</form>
		</div>
	</article>

	<!-- option -->
	<article id="option">
		<h2 class="major">選項</h2>

		<form>
			<h3 class="major">組別</h3>
			<ul>
				@foreach($groups as $group)
					<li>{{$group->projectname}}</li>
				@endforeach
			</ul>
			<br>
			<ul class="actions">
				<li><input type="button" value="修改個人資料" onclick="location.href='#change_account'" class="primary" /></li>
				<li><input type="button" value="登出" onclick="location.href='#is_logout'" /></li>
			</ul>
		</form>
	</article>

	<!-- change_account -->
	@include('modify_check')

	<!-- logout -->
	@include('logout_check')
@endsection