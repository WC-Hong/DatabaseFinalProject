<article id="change_account">
	<h2 class="major">帳戶更改</h2>
	<div id="change_message" style="background-color: #c51f1a;color: white;text-align: center"></div>
	<form autocomplete="off" novalidate="" name="modify">
		@csrf
		<div class="fields">
			<div class="field half">
				<label for="user">帳號(學號或教師編號)</label>
				<input id="user" type="text" name="user" value="{{$user}}" disabled/>
			</div>

			<div class="field half">
				<label for="username">是否要修改密碼?</label>
				<input type="radio" id="demo-priority-low" name="identity" value="manager" onchange="change_pass();" />
				<label for="demo-priority-low">是</label>
				<input type="radio" id="demo-priority-high" name="identity" value="users"  onchange="change_pass();" checked/>
				<label for="demo-priority-high">否</label>
			</div>

			<div class="field half">
				<label for="pass">密碼</label>
				<input id="pass" type="password" name="pass" disabled />
			</div>

			<div class="field half">
				<label for="pass">確認密碼</label>
				<input id="pass2" type="password" name="pass2" disabled />
			</div>

			<div class="field half">
				<label for="name">姓名</label>
				<input id="name" type="text" name="name" value="{{$name}}"/>
			</div>

			<div class="field half">
				<label for="tele">電話號碼</label>
				<input id="phone" type="text" name="phone" value="{{$phone}}" />
			</div>

			<div class="field">
				<label for="ema">電子信箱</label>
				<input id="email" type="email" name="email" value="{{$email}}"/>
			</div>
		</div>

		<ul class="actions">
			<li><input type="button" value="確認送出" onclick="change_account('{{url('/modify/')}}');" class="primary" /></li>
			<li><input type="button" value="返回" onclick="location.href='#option'" /></li>
		</ul>
	</form>
</article>