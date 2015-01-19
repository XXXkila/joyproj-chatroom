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
				email:		false,
				verify:		false,
		}

		function onForget() {
			$("#submit_btn").html("发送中。。。")
			$("#submit_btn").addClass("disabled")
			for (var i in checkStatus) {
				if (!checkStatus[i]) {
					$("#" + i).blur()
					$("#submit_btn").html("发送邮件")
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
			$.post("<?=site_url('welcome/ajaxValidateEmailAndExist')?>", {"email": email}, function(data) {
				if(!data.status) {
					checkStatus.email = false
					errorStatus('email', data.msg)					
				} else {
					checkStatus.email = true
					successStatus('email', "")			
				}
			}, "json")
		}
		
		function checkVerify() {
			warningStatus("verify", "检测中。。。")
			var verify = $("#verify").val()
			if (verify == "") {
				checkStatus.verify = false
				return errorStatus('verify', '验证码不能为空')
			}
			$.post("<?=site_url('welcome/ajaxCheckVerifyCode')?>", {"verify": verify}, function(data) {
				if(!data.status) {
					checkStatus.verify = false
					errorStatus('verify', '验证码不正确')					
				} else {
					checkStatus.verify = true
					successStatus('verify', "")			
				}
			}, "json")
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
			$("#verify").blur(checkVerify)

			$("#email").focus(function() {clearStatus('email');})
			$("#verify").focus(function() {clearStatus('verify');})
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
			<br />
			<div id="form_panel" class="col-md-offset-8 col-md-4">
				<br />
				<h4 class="text-center text-info">忘记密码</h4>
				<h5 class="text-right"><a href="<?=site_url('welcome/index')?>">&gt;&gt; 返回首页 </a></h5>				
				<form role="form" action="<?=site_url('welcome/handleForget')?>" method="post" onsubmit="return onForget()">
					<div class="form-group has-feedback">
						<label for="email">邮箱地址</label>
						<input type="text" class="form-control" id="email" name="email">
						<span id="email_icon" class="glyphicon form-control-feedback"></span>
						<span id="email_err" class="help-block"></span>
					</div>
					<div class="form-group has-feedback">
						<label for="verify">验证码</label>
						<input type="text" class="form-control" id="verify" name="verify">
						<span id="verify_icon" class="glyphicon form-control-feedback"></span>
						<span id="verify_err" class="help-block"></span>
					</div>
					<div class="form-group">
						<img alt="验证码" src="<?=site_url('welcome/getVerifyCode/' . time())?>" width="100px" height="35px" onclick="this.src='<?=site_url('welcome/getVerifyCode')?>?t=' + new Date().getTime()" style="border: 1px solid #aaa; border-radius: 3px; cursor: pointer;" />
						<small>看不清可以点击图片换一张哦～</small>
					</div>
					<hr />
					<button id="submit_btn" type="submit" class="btn btn-block btn-info">发送邮件</button>
					<br /><br /><br />
				</form>
			</div>			
		</section>
	</body>
</html>
