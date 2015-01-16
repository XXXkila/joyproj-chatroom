<!DOCTYPE html>
<html lang="zh-cn">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JoyProj</title>

	<!-- Bootstrap -->
	<link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		body {
			background: url("<?=base_url('public/img/admin-bg.jpg')?>") no-repeat;
			background-size: 100%;
		}
		iframe {
			width: 100%;
			background: #fff;
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
			// 调整iframe的高度
			var bodyHeight = window.screen.availHeight
			$("iframe[name=if]").attr("height", bodyHeight - 165)
			
			// 导航链接点击效果
			$("a.list-group-item").click(function() {
				$("a.list-group-item").removeClass("active")
				$(this).addClass("active")
			})
		}
	</script>
	
	</head>
	
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="javascript:void(0)">聊天室 - 后台</a>
				</div>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">管理员：[<strong> root </strong>]</a></li>
					<li class="active"><a href="<?=site_url('jmjoyadmin/handleSignOut')?>">注销</a></li>
				</ul>
			</div>	<!-- /container -->
		</nav>
		<br /><br /><br />
		<section class="container">
			<div class="row">
				<div class="col-md-2">
					<div class="list-group">
						<a href="<?=site_url('jmjoyadmin/home')?>" target="if" class="list-group-item active">基本信息</a>
						<a href="<?=site_url('jmjoyadmin/user')?>" target="if" class="list-group-item">用户管理</a>
						<a href="<?=site_url('jmjoyadmin/category')?>" target="if" class="list-group-item">分类管理</a>
						<a href="<?=site_url('jmjoyadmin/room')?>" target="if" class="list-group-item">房间管理</a>
						<a href="<?=site_url('jmjoyadmin/info')?>" target="if" class="list-group-item">服务器信息</a>
					</div>
				</div>	<!-- /col-md-2 -->
				<div class="col-md-10">
					<iframe name="if" src="<?=site_url('jmjoyadmin/home')?>"></iframe>
				</div>	<!-- /col-md-10 -->
			</div>
		</section>
	</body>
</html>
