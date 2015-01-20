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
			background: url("<?=base_url('public/img/room-bg.jpg')?>") no-repeat;
			background-size: 100%;
		}
		#msg_input { 
			width: 70%; 
		}
		#msg_panel, #user_panel, #user_list {
			height: 0;
		}
		#msg_panel, #user_list {
			overflow-x: hidden;
			overflow-y: scroll;
		}
		#user_table_td {
			padding-left: 5%;
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
	<script src="/public/jquery/jquery.scrollTo-min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="/public/bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		var getUrl = "<?=site_url('room/getMsg')?>"
		var sendUrl = "<?=site_url('room/sendMsg')?>"
	
		window.onload = function() {
			var bodyHeight = window.screen.availHeight
			var height = bodyHeight - 220
			$("#msg_panel").css("height", height)
			$("#user_panel").css("height", height)
			$("#user_list").css("height", height - 45)

			getMsg(0);
		};

		function send() {
			var msg = $("#msg_input").val()
			if (msg == "") {
				return
			}
			$("#msg_input").val("")
		}

		function onEnter(e) {
		    if(e.charCode == 13 || e.keyCode == 13) {
		        $('#msg_btn').click()
		        e.preventDefault()
			}
		}

		function getMsg(timestamp) {
			$.post(getUrl, {"time": timestamp}, function(data) {
				display(data.msgs)
				getMsg(data.timestamp)
			}, "json")
		}

		function display(msgs) {
			for (var i in msgs) {
				var msg = msgs[i]
				var str = "<h5><strong>"+ msg.username +"</strong>&nbsp;&nbsp;&nbsp;<small>" + msg.time + "</small></h5><p>" + msg.content + "</p>"
			    $('#msg_list').append(str);
			}
		    $('#msg_panel').scrollTo('max')
		}
		
	</script>
	</head>
	
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="javascript:void(0)">当前频道：<small><?=$cate_name?></small></a>
				</div>

				<div class="nav navbar-nav navbar-right">
					<a class="btn btn-default navbar-btn" href="<?=site_url('welcome/index')?>">退出聊天室</a>
				</div>
				
				<div class="nav navbar-nav navbar-right">
					<a class="navbar-brand" href="javascript:void(0)"><small>身份： <?=$username?></small></a>
				</div>
			</div>
		</nav>
		<br /><br /><br />
		<section class="container">
			<div class="row">
				<div class="col-md-9">
					<div id="msg_panel" class="panel panel-default">
				  		<div id="msg_list" class="panel-body">
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div id="user_panel" class="panel panel-default">
						<div class="panel-heading">
							当前在线：
							<span class="badge">42</span>
						</div>
						<div id="user_list">
							<table class="table table-condensed">
								<?php foreach (range(0, 100) as $row): ?>
								<tr><td id="user_table_td"> <span class="glyphicon glyphicon-user"></span> jmjoy</td></tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
		<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
		<div class="container">
			<form class="navbar-form" role="search">
				<input id="msg_input" type="text" class="form-control disabled" autofocus onkeypress="onEnter(event)" <?=isset($_SESSION['user']['id'])?'':'disabled'?> >
				<button id="msg_btn" type="button" class="btn btn-default <?=isset($_SESSION['user']['id'])?'':'disabled'?>" onclick="send()" >发送</button>
			</form>
		</div>
		</nav>
	</body>
</html>
