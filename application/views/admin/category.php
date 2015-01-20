<!DOCTYPE html>
<html lang="zh-cn">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JoyProj</title>

	<!-- Bootstrap -->
	<link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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
	
	<body class="container-fluid">
		<br />
		<div class="row">
		
			<div class="col-xs-6">
				<div class="panel panel-default">
					<div class="panel-heading">一级分类</div>
					<!-- List group -->
					<div class="list-group">
						<?php foreach ($top as $row): ?>
						<a href="<?=site_url('jmjoyadmin/category/'.$row->id)?>" class="list-group-item <?=$row->id==$id?'active':''?>"><?=$row->name?></a>
						<?php endforeach; ?>
						<a href="javascript:void(0)" class="list-group-item">
							<form class="form-inline" role="form" action="<?=site_url('jmjoyadmin/handleAddCategory/'.$id)?>" method="post">
								<div class="form-group">
									<input type="text" class="form-control" name="name" />
									<input type="hidden" name="parent_id" value="0" />
								</div>
								<button type="submit" class="btn btn-default">添加分类</button>
							</form>
						</a>
					</div>
				</div>
			</div>
			
			<div class="col-xs-6">
				<div class="panel panel-default">
					<div class="panel-heading">二级分类</div>
					<!-- List group -->
					<div class="list-group">
					
						<?php if (isset($sub)): ?>
					
						<?php foreach ($sub as $row): ?>
						<a href="javascript:void(0)" class="list-group-item"><?=$row->name?></a>
						<?php endforeach; ?>
						<a href="javascript:void(0)" class="list-group-item">
							<form class="form-inline" role="form" action="<?=site_url('jmjoyadmin/handleAddCategory/'.$id)?>" method="post">
								<div class="form-group">
									<input type="text" class="form-control" name="name" />
									<input type="hidden" name="parent_id" value="<?=$id?>" />
								</div>
								<button type="submit" class="btn btn-default">添加分类</button>
							</form>
						</a>
						<?php endif; ?>
						
					</div>
				</div>
			</div>		
			
		</div>
	</body>
</html>
