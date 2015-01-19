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

		window.onload = function() {
			var remainTime =  $("#remain_time").html()
			if (!remainTime) {
				return
			}
			var timestamp = 20 * 60
			var timer = setInterval(function() {
				timestamp--
				var min = Math.floor(timestamp / 60)
				var sec = timestamp % 60
				var show = min + " 分 " + sec + " 秒 "
				$("#remain_time").html(show)
				if (timstamp <= 0) {
					clearInterval(timer)
				}
			}, 1000)
		}
	
		function clickEmail() {
			//跳转到指定的邮箱登录页面
	        var uurl = $("#email_link").html()
	        
	        uurl = gotoEmail(uurl);
	        if (uurl != "") {
		    	window.location.href = "http://" + uurl
	        } else {
	            alert("抱歉!未找到对应的邮箱登录地址，请自己登录邮箱查看邮件！");
	        }
		} 
	
	    //功能：根据用户输入的Email跳转到相应的电子邮箱首页
	    function gotoEmail($mail) {
	        $t = $mail.split('@')[1];
	        $t = $t.toLowerCase();
	        if ($t == '163.com') {
	            return 'mail.163.com';
	        } else if ($t == 'vip.163.com') {
	            return 'vip.163.com';
	        } else if ($t == '126.com') {
	            return 'mail.126.com';
	        } else if ($t == 'qq.com' || $t == 'vip.qq.com' || $t == 'foxmail.com') {
	            return 'mail.qq.com';
	        } else if ($t == 'gmail.com') {
	            return 'mail.google.com';
	        } else if ($t == 'sohu.com') {
	            return 'mail.sohu.com';
	        } else if ($t == 'tom.com') {
	            return 'mail.tom.com';
	        } else if ($t == 'vip.sina.com') {
	            return 'vip.sina.com';
	        } else if ($t == 'sina.com.cn' || $t == 'sina.com') {
	            return 'mail.sina.com.cn';
	        } else if ($t == 'tom.com') {
	            return 'mail.tom.com';
	        } else if ($t == 'yahoo.com.cn' || $t == 'yahoo.cn') {
	            return 'mail.cn.yahoo.com';
	        } else if ($t == 'tom.com') {
	            return 'mail.tom.com';
	        } else if ($t == 'yeah.net') {
	            return 'www.yeah.net';
	        } else if ($t == '21cn.com') {
	            return 'mail.21cn.com';
	        } else if ($t == 'hotmail.com') {
	            return 'www.hotmail.com';
	        } else if ($t == 'sogou.com') {
	            return 'mail.sogou.com';
	        } else if ($t == '188.com') {
	            return 'www.188.com';
	        } else if ($t == '139.com') {
	            return 'mail.10086.cn';
	        } else if ($t == '189.cn') {
	            return 'webmail15.189.cn/webmail';
	        } else if ($t == 'wo.com.cn') {
	            return 'mail.wo.com.cn/smsmail';
	        } else if ($t == '139.com') {
	            return 'mail.10086.cn';
	        } else {
	            return '';
	        }
	    };
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
				<?php if ($status == 'true'): ?>
				<h4 class="text-center text-info">邮件已经发送</h4>
				<h5 class="text-right"><a href="<?=site_url('welcome/index')?>">&gt;&gt; 返回首页 </a></h5>
				<h2><small>请登录到您的邮箱：</small></h2>
				<h2><a id="email_link" href="javascript:clickEmail()"><?=$email?></a></h2>
				<h3><small>邮件有效时间：</small><span id="remain_time" class="text-danger">20分</span></h3>
				<?php elseif ($status == 'false'): ?>
				<h4 class="text-center text-danger">邮件发送失败</h4>
				<h5 class="text-right"><a href="<?=site_url('welcome/index')?>">&gt;&gt; 返回首页 </a></h5>
				<?php endif; ?>
				<br /><br /><br />
			</div>
		</section>
	</body>
</html>
