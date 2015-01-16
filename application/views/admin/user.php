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
	
    <link rel="stylesheet" type="text/css" href="<?=base_url('public/easyui/themes/bootstrap/easyui.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('public/easyui/themes/icon.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('public/easyui/themes/color.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('public/easyui/demo/demo.css')?>">
    <script type="text/javascript" src="<?=base_url('public/easyui/jquery.easyui.min.js')?>"></script>
	
	</head>
		
	<body>
		<div class="container-fluid">
		    <table id="dg" title="用户列表" class="easyui-datagrid" style="width:100%; height: 500px;"
		            url="<?=site_url('user/')?>"
		            toolbar="#toolbar" pagination="true"
		            rownumbers="true" fitColumns="true" singleSelect="true">
		        <thead>
		            <tr>
		                <th field="username" width="100">用户名</th>
		                <th field="email" width="100">Last Name</th>
		                <th field="ctime" width="100">Phone</th>
		            </tr>
		        </thead>
		    </table>
		    <div id="toolbar">
		        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New User</a>
		        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit User</a>
		        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove User</a>
		    </div>
		    
		    <div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
		            closed="true" buttons="#dlg-buttons">
		        <div class="ftitle">User Information</div>
		        <form id="fm" method="post" novalidate>
		            <div class="fitem">
		                <label>First Name:</label>
		                <input name="firstname" class="easyui-textbox" required="true">
		            </div>
		            <div class="fitem">
		                <label>Last Name:</label>
		                <input name="lastname" class="easyui-textbox" required="true">
		            </div>
		            <div class="fitem">
		                <label>Phone:</label>
		                <input name="phone" class="easyui-textbox">
		            </div>
		            <div class="fitem">
		                <label>Email:</label>
		                <input name="email" class="easyui-textbox" validType="email">
		            </div>
		        </form>
		    </div>
		    <div id="dlg-buttons">
		        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
		        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
		    </div>
	    </div>
	    <script type="text/javascript">
	        var url;
	        function newUser(){
	            $('#dlg').dialog('open').dialog('setTitle','New User');
	            $('#fm').form('clear');
	            url = 'save_user.php';
	        }
	        function editUser(){
	            var row = $('#dg').datagrid('getSelected');
	            if (row){
	                $('#dlg').dialog('open').dialog('setTitle','Edit User');
	                $('#fm').form('load',row);
	                url = 'update_user.php?id='+row.id;
	            }
	        }
	        function saveUser(){
	            $('#fm').form('submit',{
	                url: url,
	                onSubmit: function(){
	                    return $(this).form('validate');
	                },
	                success: function(result){
	                    var result = eval('('+result+')');
	                    if (result.errorMsg){
	                        $.messager.show({
	                            title: 'Error',
	                            msg: result.errorMsg
	                        });
	                    } else {
	                        $('#dlg').dialog('close');        // close the dialog
	                        $('#dg').datagrid('reload');    // reload the user data
	                    }
	                }
	            });
	        }
	        function destroyUser(){
	            var row = $('#dg').datagrid('getSelected');
	            if (row){
	                $.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
	                    if (r){
	                        $.post('destroy_user.php',{id:row.id},function(result){
	                            if (result.success){
	                                $('#dg').datagrid('reload');    // reload the user data
	                            } else {
	                                $.messager.show({    // show error message
	                                    title: 'Error',
	                                    msg: result.errorMsg
	                                });
	                            }
	                        },'json');
	                    }
	                });
	            }
	        }
	    </script>
	    <style type="text/css">
	        #fm{
	            margin:0;
	            padding:10px 30px;
	        }
	        .ftitle{
	            font-size:14px;
	            font-weight:bold;
	            padding:5px 0;
	            margin-bottom:10px;
	            border-bottom:1px solid #ccc;
	        }
	        .fitem{
	            margin-bottom:5px;
	        }
	        .fitem label{
	            display:inline-block;
	            width:80px;
	        }
	        .fitem input{
	            width:160px;
	        }
	    </style>
		
	</body>
	
</html>