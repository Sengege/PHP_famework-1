<!--
Coder:          LUKE Bei
Email:          luke.bei.2015@gmail.com
Data:           23.3.2016
Version:        1.0
Description:    First Page's html code.
-->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
updateSession();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');

if (isset($_SESSION["user_id"])) {
    $_user = User::__constructWithIdFromDB(urlencode($_SESSION["user_id"]));
} else {
    //redirect_to("home.php");
    //in case redirect doesn't work I don't want page to crush by calling methods on null object
    $_user = new User();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="Bookmark" href="../images/favicon.ico">
    <meta charset="UTF-8">
    <title>First page</title>
    <link rel="stylesheet" type="text/css" href="../css/FirstPage_style.css">
    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/first_page.js"></script>
</head>

<body>
    <div id="main_box">
        <img id="img" src="../images/3_skill.jpg"></div>

    <a href="cate_items.php">
        <div id="inner01_box">
            <div id="inner01_cell">
                <p>ITEMS</p>
            </div>
        </div>
    </a>
    <a href="cate_experiences.php">
        <div id="inner02_box">
            <div id="inner02_cell">
                <h1>Experiences</h1>
                <h2>travel for life</h2>
            </div>
        </div>
    </a>
    <a href="cate_skills.php">
        <div id="inner03_box">
            <div id="inner03_cell">
                <h1>SKILLS</h1>
                <h2>learn more</h2>
            </div>
        </div>
    </a>
    <a href="home.php">
        <div id="inner04_box">
            <div id="inner04_cell">
                <p>HOME</p>
            </div>
        </div>
    </a>
</body>

</html>