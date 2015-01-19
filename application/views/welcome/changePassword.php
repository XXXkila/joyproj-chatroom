<!DOCTYPE html>
<html lang="zh-cn">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>注册 - JoyProj</title>

	<!-- Bootstrap -->
	<link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		body {
			background: url("<?=base_url('public/img/index-bg.jpg')?>") no-repeat;
			background-size: 100%;
		}
		#form_panel {
			background: rgba(255, 255, 255, 0.8);
		}
	</style>
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="/public/jquery/jquery-1.11.2.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="/public/bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		var checkStatus = {
				password:	false,
				repassword:	false,
		}

		function onSignUp() {
			$("#submit_btn").html("修改中。。。")
			$("#submit_btn").addClass("disabled")
			for (var i in checkStatus) {
				if (!checkStatus[i]) {
					$("#" + i).blur()
					$("#submit_btn").html("修改")
					$("#submit_btn").removeClass("disabled")					
					return false
				}
			}
			return true
		}
		
		function checkEmail() {
			warningStatus("email", "检测中。。。")
			var email = $("#email").val()
			if (email == "") {
				checkStatus.email = false
				return errorStatus('email', '邮箱地址不能为空')
			}
			$.post("<?=site_url('welcome/ajaxValidateEmail')?>", {"email": email}, function(data) {
				if(!data.status) {
					checkStatus.email = false
					errorStatus('email', data.msg)					
				} else {
					checkStatus.email = true
					successStatus('email', "")			
				}
			}, "json")
		}
		
		function checkPassword() {
			warningStatus("password", "检测中。。。")
			var password = $("#password").val()
			if (password == "") {
				checkStatus.password = false
				return errorStatus('password', '密码不能为空')
			}
			if (!(/^\S{6,32}$/.test(password))) {
				checkStatus.password = false
				return errorStatus('password', '密码格式不对')
			}
			checkStatus.password = true
			successStatus('password', "")
		}
		
		function checkRepassword() {
			warningStatus("repassword", "检测中。。。")
			var repassword = $("#repassword").val()
			if (repassword == "") {
				checkStatus.repassword = false
				return errorStatus('repassword', '确认密码不能为空')
			}
			if ($("#password").val() != repassword) {
				checkStatus.repassword = false
				return errorStatus('repassword', '两次密码不一致')
			}
			checkStatus.repassword = true
			successStatus('repassword', "")			
		}

		function checkUsername() {
			warningStatus("username", "检测中。。。")
			var username = $("#username").val()
			if (username == "") {
				checkStatus.username = false
				return errorStatus('username', '用户名不能为空')
			}
			if (!(/^[-\w\u4E00-\u9FA5]{2,8}$/.test(username))) {
				checkStatus.username = false
				return errorStatus('username', '用户名格式不对')
			}
			checkStatus.username = true
			successStatus('username', "")
		}
		
		function warningStatus(id, msg) {
			var parent = $("#" + id).parent("div")
			var icon = $("#" + id + "_icon")
			var err = $("#" + id + "_err")
			
			parent.removeClass("has-success")
			parent.removeClass("has-warning")
			parent.removeClass("has-error")
			
			icon.removeClass("glyphicon-ok")
			icon.removeClass("glyphicon-warning-sign")
			icon.removeClass("glyphicon-remove")

			err.removeClass("text-success")
			err.removeClass("text-warning")			
			err.removeClass("text-danger")			
			
			parent.addClass("has-warning")
			icon.addClass("glyphicon-warning-sign")
			err.addClass("text-warning")

			err.html(msg)
		}
		
		function successStatus(id, msg) {
			var parent = $("#" + id).parent("div")
			var icon = $("#" + id + "_icon")
			var err = $("#" + id + "_err")
			
			parent.removeClass("has-success")
			parent.removeClass("has-warning")
			parent.removeClass("has-error")
			
			icon.removeClass("glyphicon-ok")
			icon.removeClass("glyphicon-warning-sign")
			icon.removeClass("glyphicon-remove")

			err.removeClass("text-success")
			err.removeClass("text-warning")			
			err.removeClass("text-danger")			
			
			parent.addClass("has-success")
			icon.addClass("glyphicon-ok")
			err.addClass("text-success")

			err.html(msg)			
		}
		
		function errorStatus(id, msg) {
			var parent = $("#" + id).parent("div")
			var icon = $("#" + id + "_icon")
			var err = $("#" + id + "_err")
			
			parent.removeClass("has-success")
			parent.removeClass("has-warning")
			parent.removeClass("has-error")
			
			icon.removeClass("glyphicon-ok")
			icon.removeClass("glyphicon-warning-sign")
			icon.removeClass("glyphicon-remove")

			err.removeClass("text-success")
			err.removeClass("text-warning")			
			err.removeClass("text-danger")			
			
			parent.addClass("has-error")
			icon.addClass("glyphicon-remove")
			err.addClass("text-danger")

			err.html(msg)			
		}

		function clearStatus(id) {
			var parent = $("#" + id).parent("div")
			var icon = $("#" + id + "_icon")
			var err = $("#" + id + "_err")
			
			parent.removeClass("has-success")
			parent.removeClass("has-warning")
			parent.removeClass("has-error")
			
			icon.removeClass("glyphicon-ok")
			icon.removeClass("glyphicon-warning-sign")
			icon.removeClass("glyphicon-remove")

			err.removeClass("text-success")
			err.removeClass("text-warning")			
			err.removeClass("text-danger")

			err.html("");
		}
		
		window.onload = function() {
			$("#email").blur(checkEmail)
			$("#password").blur(checkPassword)
			$("#repassword").blur(checkRepassword)
			$("#username").blur(checkUsername)

			$("#email").focus(function() {clearStatus('email');})
			$("#password").focus(function() {clearStatus('password');})
			$("#repassword").focus(function() {clearStatus('repassword');})
			$("#username").focus(function() {clearStatus('username');})
		}
		
	</script>
	
	</head>
	
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="javascript:void(0)">网络聊天室</a>
				</div>
			</div>
		</nav>	
		<br /><br /><br />
		<section class="container">
			<div id="form_panel" class="col-md-offset-8 col-md-4">
				<br />
				<h4 class="text-center text-info">修改密码</h4>
				
				<?php if ($status): ?>
				
				<form role="form" action="<?=site_url('welcome/handleChangePassword')?>" method="post" onsubmit="return onSignUp()">
					<div class="form-group has-feedback">
						<label for="password">密码</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="密码（6~32字符，不含空格）">
						<span id="password_icon" class="glyphicon form-control-feedback"></span>
						<span id="password_err" class="help-block"></span>
					</div>
					<div class="form-group has-feedback">
						<label for="repassword">确认密码</label>
						<input type="password" class="form-control" id="repassword" placeholder="再次输入密码">
						<span id="repassword_icon" class="glyphicon form-control-feedback"></span>
						<span id="repassword_err" class="help-block"></span>
					</div>
					<hr />
					<button id="submit_btn" type="submit" class="btn btn-default">修改</button>
					<br /><br />
				</form>
				
				<?php else: ?>
				
				<h5 class="text-right"><a href="<?=site_url('welcome/index')?>">&gt;&gt; 返回首页 </a></h5>
				<hr />		
				<h4 class="text-center text-primary">激活链接已经过期</h4>
				<h4 class="text-center text-primary">请重新发送邮件！</h4>
				<br /><br />
				
				<?php endif; ?>
				
			</div>
		</section>
	</body>
</html>
