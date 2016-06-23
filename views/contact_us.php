<!DOCTYPE html>
<html>
<head>
    <title>SWOPE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="../css/home_style.css" media="screen">
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/zlight.menu.css" media="screen">
    <script src="../js/jquery.zlight.menu.1.0.min.js"></script>
    <script src="../js/respond.min.js"></script>
    <script type="text/javascript"  src="../js/content.js"></script>
</head>
<body>
<header>
    <?php
    if((isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]))) include("share_page/header_logged_new.php");
    else include("share_page/header.php"); ?></header>

<div class="topic" style="margin-top: 100px;">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li class="active">Contact us</li>
            </ol>
        </div>
        <!-- / .row -->
    </div>
    <!-- / .container -->
</div>
<div class="container" style="margin-bottom: 50px;">
    <div class="row">

        <div class="col-sm-8">
            <h1 class="first-child">
                <span class="text-red" style="color:#ff8542;">Let’s</span>
                keep in touch
            </h1>
            <p>
                For general questions, feedback, and cool new ideas for SWOPE, please head over to the SWOPE Social Community. We love to hear from our users and regularly use your ideas to make SWOPE even better.
            </p>
            <form role="form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter Your Name"></div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter Your Mail"></div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" rows="3" id="message" placeholder="Type Message"></textarea>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox">I have read the rules and agree to abide by them</label>
                </div>
                <button type="submit" class="btn btn-lg btn-danger">Send Request</button>
            </form>
        </div>
        <div class="col-sm-4">
            <h1 class="second-child">
                Get In
                <span class="text-red" style="color:#ff8542;">Touch</span>
            </h1>
            <p>
                Facebook:
                <a href="">swope.facebook.com</a>
                <br />
                Weibo:
                <a href="http://weibo.com/u/5676915807?is_all=1">http://swope.weibo.com</a>
                <br />
                Email:
                <a href="mailto:#">contact@swope.com</a>
            </p>

        </div>

    </div>
    <!-- / .row -->
</div>

<!-- footer begin -->
<footer id="footer" class="footer" >
    <?php include("share_page/footer.html"); ?></footer>
</body>
</html>