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
    <script type="text/javascript" src="../js/GoTop.js"></script>
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
                <li class="active">About</li>
            </ol>
        </div>
        <!-- / .row -->
    </div>
    <!-- / .container -->
</div>
<div class="container">
    <div class="row">
        <!-- Vertical Navigation -->
        <div class="col-md-3">
            <div class="panel-group" id="help-nav">
                <div class="panel">
                    <div class="panel-heading bg-darkblue" style="background-color:#f5f5f5; ">
                        <a data-toggle="collapse" data-parent="#help-nav" href="#help-nav-one" > <strong style="padding-left: 35px;">USER MENU</strong>
                        </a>
                    </div>
                    <div id="help-nav-one" class="menu_left">
                        <div class="panel-body" >
                            <ul>
                                <li >
                                    <a href="#our_story">ABOUT THE WEB APP</a>
                                </li>
                                <li>
                                    <a href="#with_us">ABOUT US</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / .col-md-3 -->
        <div class="col-md-9">

            <!-- Typography -->
            <h2  id="our_story">
                <span>About The Web App</span>
            </h2>
            <hr />
            <div class="row">
                <div class="col-sm-8">
                    <ul>
                        <li>
                            <a href="#QUE1">What does the term Swope mean?</a>
                        </li>
                        <li>
                            <a href="#QUE2">What's the web App's purpose?</a>
                        </li>
                        <li>
                            <a href="#QUE3">How did you come up with the idea?</a>
                        </li>
                    </ul>
                    <br />
                    <p class="text-danger" id="QUE1"> <font size="+1">What does the term Swope mean?</font>
                    </p>
                    <p class="text-muted">
                        The term Swope comes from swop, which is an informal term for exchange, trade. We added an "e" at the end to remind the e from exchange but also make it look nice and sounds cute.
                    </p>
                    <p class="text-success" id="QUE2"> <font size="+1">What's the web App's purpose?</font>
                    </p>
                    <p class="text-muted">
                        Swope is here to enable students to swap objects, but also exchange skills and share experiences.
                        <br/>
                        The idea is to exchange things. Those things can be physical items such as a camera, clothes or books. But it can also be non-physical such as skills or experiences. Skills can be artistic, cooking skills, computer skills, etc. Experiences can be about sharing the places you like to go to for food, the nice places you think a person should visit if on holiday in your city …
                        <br/>
                        The purpose is being able to exchange not only an object for an object or a skill for a skill, but rather exchanging in whatever way people want to exchange. For example a book could be exchanged with the share of an experience of the city a student might be living in, etc.
                        <br/>
                        Swope aims to bring students together, have fun and create new friendships.
                    </p>
                    <p class="text-warning" id="QUE3">
                        <font size="+1">How did you come up with the idea?</font>
                    </p>
                    <p class="text-muted">
                        The idea came from the statement that on one hand students tend to accumulate a lot of things during their time at university and on the other hand other students might need second hand things because they cannot afford to buy them new.
                        <br/>
                        However, instead of having more material things by exchanging a physical thing for another one, some students might actually want to swop objects for a dinner for example, exchange that this web application would allow.
                        <br/>
                        With the cultural aspect of this project and the travel it implies, we also thought it might be a good idea to have students sharing their experiences about their cities or countries with foreign students, making their stay more enjoyable. For example, sharing deals about a place to go for food, a great park to go for a run, etc.
                    </p>

                </div>
                <div class="col-sm-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">RELATED LINKS</h3>
                        </div>
                        <div class="panel-body">
                            <ul>
                                <li>
                                    <a href="support.php">SUPPORT</a>
                                </li>
                                <li>
                                    <a href="contact_us.php">CONTACT US</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title">THANK YOU!</h3>
                        </div>
                        <div class="panel-body">
                            Thanks to
                            <a href="http://www.zzili.edu.cn/">ZZULI</a>
                            and
                            <a href="http://www.napier.ac.uk/">Edinburgh Napier University</a>
                            support for our IGP project.
                        </div>
                    </div>
                </div>
            </div>
            <h2 id="with_us">
                <span>About Us</span>
            </h2>
            <hr />
            <p class="text-danger" id="QUE3">
                <font size="+1">Who are we?</font>
            </p>


            <p class="text-muted">
                We are a bunch of truly multicultural students (French, Chinese, Polish, Scottish, Romanian), with a wide variety of backgrounds and ages. We are super excited to develop this web app as part of our university’s semester, while also having immense amounts of fun and bonding new friendships. <br/>We call ourselves the IGP (aka. The International Group Project) and are proud to be the representatives of our universities (Napier & Zzuli) in our travels around Scotland or China. We are all an amazing bunch, always on the lookout for something new to explore, experience or learn and we are having massive amounts of fun working on this project. <br/>The IGP has been a collaborative effort between the two groups of students at Napier and Zzuli, spread across a number of 3 months spanning over 7 time zones. Through a sustained and collaborative effort, we are now able to reach the completion of the project. Although we all worked our best and as hard as our capacity allowed, it is in the rare moments of dire need when true character comes alive and one person outshines all the rest - one such person is our project manager (aka G.) who has always lead the project from the very beginning and up to the last minute of its glorious completion. From all of us in the team, a big Thank You J and we could not have done it without you.
            </p>
            <div class="row">
                <div class="col-sm-2  col-xs-6">
                    <img src="../images/member/gee.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">DESIGNER</h4>
                        <h5 style="color: #ff8542">@Garance</h5>
                    </center>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/luke.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">FRONT-END DEVELOPER</h4>
                        <h5 style="color: #ff8542">@LUKE_bei</h5>
                    </center>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/adam.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">BACK-END DEVELOPER</h4>
                        <h5 style="color: #ff8542">@Adam</h5>
                    </center>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/taylor.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">DESIGNER</h4>
                        <h5 style="color: #ff8542">@Taylor</h5>
                    </center>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/sandy.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">FRONT-END DEVELOPER</h4>
                        <h5 style="color: #ff8542">@Sandy</h5>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/eve.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">FRONT-END DEVELOPER</h4>
                        <h5 style="color: #ff8542">@Eve</h5>
                    </center>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/robert.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">BACK-END DEVELOPER</h4>
                        <h5 style="color: #ff8542">@Robert</h5>
                    </center>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/annie.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">FRONT-END DEVELOPER</h4>
                        <h5 style="color: #ff8542">@Annie</h5>
                    </center>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/tony.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">BACK-END DEVELOPER</h4>
                        <h5 style="color: #ff8542">@Tony</h5>
                    </center>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <img src="../images/member/glen.jpg" class="img-circle" width="100%">
                    <center>
                        <h4 style="color: #9c9c9c">FRONT-END DEVELOPER</h4>
                        <h5 style="color: #ff8542">@Glen</h5>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="goToTop">
    <a href="#">
        <img src="../images/up.png" />
    </a>
</div>

<!-- footer begin -->
<footer id="footer" class="footer" >
    <?php include("share_page/footer.html"); ?></footer>
</body>
</html>