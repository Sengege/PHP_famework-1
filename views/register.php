<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="Bookmark" href="../images/favicon.ico">
	<title>SWOPE</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/register_style.css">
	<script src="../js/jquery-2.1.3.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/common.js"></script>
	<script src="../js/jquery.validate.min.js"></script>
</head>

<body>

	<p class="active-tab">
		<a  href="home.php">
			<img src="../images/Logo_v3-01.png" width="10%" />
		</a>
		|
		<span></span>
	</p>
	<div class="container">
		<?php include ('share_page/message_box.php')?>
		<div class="container-fluid">
			<ul id="myTab" class="nav nav-tabs nav-justified">
				<li class="active">
					<a href="#home" data-toggle="tab">个人用户</a>
				</li>
				<li>
					<a href="#E_home" data-toggle="tab">International customers</a>
				</li>
			</ul>
		</div>
		<!-- Chinese content "register" -->
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade in active" id="home">
				<form class="form-horizontal" role="form" action="../classes/routers/register_router.php" method="post" id="registerFormCN" name="registerFormCN">
					<div class="form-group">
						<label for="username"
                           class="col-xs-8 col-xs-offset-1 col-sm-3 col-sm-offset-1 control-label">用户名：</label>
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-4 col-lg-4">
							<input type="text" name="usernameCN" class="form-control" id="usernameCN"></div>
					</div>
					<div class="form-group">
						<label for="email"
                           class="col-xs-8 col-xs-offset-1 col-sm-3 col-sm-offset-1 control-label">邮箱：</label>
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-4 col-lg-4">
							<input type="email" name="emailCN" class="form-control" id="emailCN"></div>
					</div>
					<div class="form-group">
						<label for="inputPassword" class="col-xs-8 col-xs-offset-1 col-sm-3 col-sm-offset-1 control-label">请设置密码：</label>
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-4 col-lg-4">
							<input type="password" name="passwordCN" class="form-control" id="inputPasswordCN"></div>
					</div>
					<div class="form-group">
						<label for="confirmPassword"
                           class="col-xs-8 col-xs-offset-1 col-sm-3 col-sm-offset-1 control-label">请确认密码：</label>
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-4 col-lg-4">
							<input type="password" name="confirm_passwordCN" class="form-control" id="confirmPasswordCN"></div>
					</div>
					<div class="form-group">
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-4 col-md-4 col-lg-4 submitRegister">
							<input type="submit" name="submitCN" class="form-control" value="立即注册"/>
						</div>
					</div>
					<div class="form-group">
						<div class=" col-xs-offset-4  col-sm-offset-8 col-md-offset-8 col-lg-offset-8">
							<p>
								已经有账号？
								<a href="login.php">登录</a>
							</p>
						</div>
					</div>
				</form>
			</div>
			<!-- English content "register" -->
			<div class="tab-pane fade " id="E_home">
				<form class="form-horizontal" role="form" action="../classes/routers/register_router.php" method="post" id="registerFormEN" name="registerFormEN">
					<div class="form-group">
						<label for="usernameEN" class="col-xs-8 col-xs-offset-1 col-sm-5 col-sm-offset-0  control-label">Username:</label>
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-4 col-lg-4">
							<input type="text" name="usernameEN" class="form-control" id="usernameEN"></div>
					</div>
					<div class="form-group">
						<label for="emailEN" class="col-xs-8 col-xs-offset-1 col-sm-5 col-sm-offset-0 control-label">
							Email
                        Address：
						</label>
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-4 col-lg-4">
							<input type="email" name="emailEN" class="form-control" id="emailEN"></div>
					</div>
					<div class="form-group">
						<label for="inputPasswordEN" class="col-xs-8 col-xs-offset-1 col-sm-5 col-sm-offset-0 control-label">Password：</label>
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-4 col-lg-4">
							<input type="password" name="passwordEN" class="form-control password" id="inputPasswordEN"></div>
					</div>
					<div class="form-group">
						<label for="confirmPasswordEN"
                           class="col-xs-10 col-xs-offset-1 col-sm-5 col-sm-offset-0 control-label">
							Confirm
                        Password:
						</label>
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-4 col-lg-4">
							<input type="password" name="confirm_passwordEN" class="form-control" id="confirmPasswordEN"></div>
					</div>
					<div class="form-group">
						<div class="col-xs-7 col-xs-offset-1 col-sm-5 col-sm-offset-5 col-md-4  col-md-offset-5 col-lg-4 col-lg-offset-5 submitRegister">
							<input type="submit" name="submitEN" class="form-control" value="Register"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-10 col-xs-offset-2  col-sm-offset-5 col-md-offset-6 col-lg-offset-7">
							<p>
								Already have an account？
								<a href="login.php">Log in</a>
							</p>
						</div>
					</div>
				</form>
			</div>
		</div>

		<script>
        $(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
// 获取已激活的标签页的名称
                var activeTab = $(e.target).text();
                $(".active-tab span").html(activeTab);
            });
        });
    </script>
	</div>
	<div class="copy" align='center'>
		Copyright&copy;2016 in the swope
		<hr/>
	</div>
</body>
</html>