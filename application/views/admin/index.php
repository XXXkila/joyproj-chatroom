<!DOCTYPE html>
<html lang="zh-cn">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin - JoyProj</title>

	<!-- Bootstrap -->
	<link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		body {
			background: url("<?=base_url('public/img/admin-bg.jpg')?>") no-repeat;
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
		<br /><br /><br />
		<div class="container">
			<div class="col-xs-4 col-xs-offset-4">
				<div class="jumbotron">
					<form class="form-signin" role="form" action="<?=site_url('jmjoyadmin/handleSignIn')?>" method="post">
						<h4 class="form-signin-heading text-primary text-center">后台管理系统</h4>
						<?php if ($msg): ?>
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong><?=$msg?></strong>
						</div>
						<?php endif; ?>
						<input name="username" type="text" class="form-control" placeholder="账号" value="<?=$username?>" autofocus />
						<input name="password" type="password" class="form-control" placeholder="密码" />
						<button class="btn btn-lg btn-info btn-block" type="submit">登陆</button>
					</form>
				</div>	<!-- /jumbotron -->
			</div>
		</div>	<!-- /container -->
	</body>
</html>
