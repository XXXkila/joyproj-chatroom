<!DOCTYPE html>
<html lang="zh-cn">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>聊天室 - JoyProj</title>

	<!-- Bootstrap -->
	<link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		body {
			background: url("<?=base_url('public/img/index-bg.jpg')?>") no-repeat;
			background-size: 100%;
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
			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">请选择频道：</div>
				  		<div class="panel-body">
				  			<h4>情感频道：</h4>
				  			<p><a href="<?=site_url('room/index')?>">男女</a> | <a href="#">男女</a></p>
				  			<h4>情感频道：</h4>
				  			<p><a href="#">男女</a> | <a href="#">男女</a></p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body">
						
							<?php if (!$is_sign_in): ?>
							
							<form class="form-signin" role="form" action="<?=site_url('welcome/handleSignIn')?>" method="post">
								<h4 class="form-signin-heading text-primary text-center">请登陆</h4>
								<?php if ($msg): ?>
								<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<strong><?=$msg?></strong>
								</div>
								<?php endif; ?>
								<input name="email" type="email" class="form-control" placeholder="邮箱" value="<?=$email?>" autofocus />
								<input name="password" type="password" class="form-control" placeholder="密码" />
								<button class="btn btn-info btn-block" type="submit">登陆</button>
								<a href="<?=site_url('welcome/signUp')?>" class="btn btn-default btn-block">注册</a>
								<h6 class="text-right"><a href="#">忘记密码？</a></h6>
							</form>
							
							<?php else: ?>
							
							<div class="media">
								<a class="media-left" href="#">
									<img src="<?=base_url('public/img/avatar.jpg')?>" alt="头像">
								</a>
								<div class="media-body">
									<h4 class="media-heading">Media heading</h4>
									...
								</div>
							</div>	<!-- /media -->
							
							<?php endif; ?>
							
						</div>
					</div>
				</div>	<!-- /col-md-4 -->
			</div>
		</section>
		
	</body>
</html>
