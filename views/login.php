<!DOCTYPE html>
<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ErrorsController.php');

?>
<head>
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="Bookmark" href="../images/favicon.ico">
    <title>login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/login_style.css">
    <script src="../js/jquery-2.1.3.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/common.js"></script>
    <script src="../js/jquery.validate.min.js"></script>
</head>
<body>

<!-- Logo picture -->
<div class="container">
    <div class="container-fluid">
        <a  href="home.php">
            <img src="../images/Logo_v3-03.png" width="120px" style="margin-top:5%;margin-left: 30%;" />
        </a>
        <ul id="myTab" class="nav nav-tabs"  style="margin-top: 20px;">
            <li class="active">
                <a href="#home" data-toggle="tab">登录</a>
            </li>
            <li>
                <a href="#E_home" data-toggle="tab">Login</a>
            </li>
        </ul>
        <!--  Chinese content "Login" -->
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="home">
                <form class="bs-example bs-example-form" role="form" action="../classes/routers/login_router.php" method="post" id="loginFormCN">
                    <br>
                    <div class="input-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 ">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-user"></span>
                        </span>
                        <input type="text" class="form-control" name="usernameCN" placeholder="用户名"></div>
                    <br>
                    <div class="input-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-lock"></span>
                        </span>
                        <input type="password" class="form-control" name="passwordCN" placeholder="密码"></div>
                    <br>
                    <div class="form-group">
                        <div class="col-xs-offset-5 col-sm-offset-8 col-sm-10">
                            <p>
                                <a href="">忘记密码？</a>
                            </p>
                        </div>
                    </div>
                    <div class="input-group col-xs-10 col-xs-offset-1 col-sm-offset-1 col-sm-10">
                        <div class="submit">
                            <input type="submit" name="loginCN" class="form-control" value="登录"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-xs-offset-2 col-sm-offset-4 col-sm-10 ccol-md-offset-0">
                            <p>
                                还没有账号？
                                <a href="register.php">立即注册</a>
                            </p>
                        </div>
                    </div>
                    <input type="hidden" name="user_rememberme" value="">
                </form>
            </div>
            <!--  English content "Login" -->
            <div class="tab-pane fade " id="E_home">
                <form class="bs-example bs-example-form" role="form" action="../classes/routers/login_router.php" method="post" id="loginFormEN">
                    <br>
                    <div class="input-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 ">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-user"></span>
                        </span>
                        <input type="text" class="form-control" name="usernameEN" placeholder="username"></div>
                    <br>
                    <div class="input-group col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-lock"></span>
                        </span>
                        <input type="password" class="form-control" name="passwordEN" placeholder="password"></div>
                    <br>
                    <div class="form-group">
                        <div class="col-xs-10 col-xs-offset-4 col-sm-offset-5 col-sm-10 col-md-8 col-md-offset-6">
                            <p>
                                <a href="">Forgot password?</a>
                            </p>
                        </div>
                    </div>
                    <div class="input-group col-xs-10 col-xs-offset-1 col-sm-offset-1 col-sm-10">
                        <div class="submit">
                            <input type="submit" name="loginEN" class="form-control" value="Login"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-11 col-xs-offset-2 col-sm-offset-4 col-sm-10 ccol-md-offset-0">
                            <p>
                                No account?
                                <a href="register.php">Sign up</a>
                            </p>
                        </div>
                    </div>
                    <input type="hidden" name="user_rememberme" value="">
                </form>
            </div>
        </div>
        <?php include ('share_page/message_box.php')?>
        <hr/>
        <div class="copy" align='center'>
            Copyright&copy;2016 in the swope
        </div>
    </div>

</div>

</body>
</html>