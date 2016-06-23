<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/SkillsCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');

updateSession();

if (isset($_SESSION["user_id"])) {
    $_user = User::__constructWithIdFromDB($_SESSION["user_id"]);
} else {
    redirect_to("home.php");
    //in case redirect doesn't work I don't want page to crash on null
    $_user = new User();
}
?>

<!DOCTYPE html>
<head>
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="Bookmark" href="../images/favicon.ico">
    <title>SWOPE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="../css/profile_style.css" media="screen">
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/zlight.menu.css" media="screen">
    <script src="../js/jquery.zlight.menu.1.0.min.js"></script>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/changeuserphoto.js"></script>
</head>
<body>
<header>
    <?php include("share_page/header_logged_new.php"); ?></header>
<div class="container"
     style="background-color: #F2F2EE;border: solid #F1E8E3; -webkit-border-radius:5%;-moz-border-radius:5%;border-radius:5%;margin-top: 1%;padding: 2% 0 2% 0;">
    <div class="row">
        <main class="col-lg-10 col-lg-offset-2  main-content">
            <form class="form-horizontal" method="post"
                  action="../classes/routers/update_profile_router.php" enctype="multipart/form-data">
                <div class="form-group" id="upload">
                    <!--<div
                        class="col-lg-2 col-lg-offset-2  col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-2 col-xs-3 col-xs-offset-0">
                        <a href="#" class="upload_person">
                            <?php
                    /*                            if ($_user->getProfilePic() == null || empty($_user->getProfilePic())) {
                                                    echo '<img src="../images/person.jpg" alt="userphoto" width="100%"  style="border:solid #fff 5px;border-radius:10px;"></a>';
                                                } else {
                                                    echo '<img src="../classes/routers/image_router.php?image=' . urlencode($_user->getProfilePic()) . '" alt="userphoto" width="100%"  style="border:solid #fff 5px;border-radius:10px;"></a>';
                                                }
                                                */ ?>
                    </div>-->
                    <div id="preview"
                         class="col-lg-2 col-lg-offset-2  col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-2 col-xs-3 col-xs-offset-0">
                        <div><?php
                            if ($_user->getProfilePic() == null || empty($_user->getProfilePic())) {
                                echo '<img src="../images/person.jpg" alt="userphoto" width="150" height="150" style="border:solid #fff 5px;border-radius:10px;"></a>';
                            } else {
                                echo '<img src="../classes/routers/image_router.php?image=' . urlencode($_user->getProfilePic()) . '" alt="userphoto" width="150" height="150" style="border:solid #fff 5px;border-radius:10px;"></a>';
                            }
                            ?>
                        </div>
                    </div>

                        <div
                            class="col-lg-4 col-lg-offset-0 col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-6 col-xs-offset-2">
                            <p for="inputfile">Upload Userphoto</p>
                            <input type="file" id="fileToUpload" name="fileToUpload" onchange="previewImage(this)">
                            <p class="help-block">
                                You can upload image in jpg or png, and the file less than 2M
                            </p>
                        </div>
                    <div class="form-group">
                        <div class="col-lg-2 col-sm-4  col-xs-3"></div>
                        <div class="col-lg-6  col-sm-5  col-xs-7">
                            <?php include('share_page/message_box.php'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-4  col-xs-3 control-label">Username</label>
                        <div class="col-lg-6  col-sm-5  col-xs-7">
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="username" value="<?php echo $_user->getName() ?>" readonly></div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2   col-sm-4 col-xs-3 control-label">Email address</label>
                        <div class="col-lg-6  col-sm-5 col-xs-7">
                            <input type="text" class="form-control" id="email_address" name="email"
                                   placeholder="email" value="<?php echo $_user->getEmail() ?>"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2  col-sm-4 col-xs-3 control-label">Location</label>
                        <div class="col-lg-6 col-sm-5 col-xs-7">
                            <input type="text" class="form-control" id="location" name="location"
                                   placeholder="China/Edinburgh" value="<?php echo $_user->getLocation() ?>"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2  col-sm-4 col-xs-3 control-label">University</label>
                        <div class="col-lg-6  col-sm-5 col-xs-7">
                            <input type="text" class="form-control" id="university" name="university"
                                   placeholder="university" value="<?php echo $_user->getUniversity() ?>"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2  col-sm-4 col-xs-3 control-label">Phone number</label>
                        <div class="col-lg-6  col-sm-5 col-xs-7">
                            <input type="text" class="form-control" id="phone_number" name="contact_no"
                                   placeholder="contact number" value="<?php echo $_user->getContactNo() ?>"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2  col-sm-4 col-xs-3 control-label">About me</label>
                        <div class="col-lg-6  col-sm-5 col-xs-7">
                            <input type="text" maxlength="150" class="form-control" name="user_description"
                                   placeholder="about me" value="<?php echo $_user->getDescription() ?>"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2  col-sm-4 col-xs-3 control-label">Skills</label>
                        <div class="col-lg-6  col-sm-5 col-xs-7">
                            <div class="plus-tag tagbtn clearfix" id="myTags">
                                <?php
                                $skills = new SkillsCollection();
                                $user_skills = $skills->getUserSkills($_SESSION["user_id"]);
                                foreach ($user_skills as $skill) {
                                    $s = $skills->getSkillById($skill['skill_id']);
                                    echo '<a value="' . htmlspecialchars($s['skill_id']) . '" title="' . htmlspecialchars($s['skill_name']) . '" href="javascript:void(0);">';
                                    echo '<span>' . htmlspecialchars($s['skill_name']) . '</span> <em></em>';
                                    echo '</a>';
                                }

                                ?>
                            </div>
                            <div class="plus-tag-add">
                                <ul class="Form FancyForm">
                                    <li>
                                        <input id="" name="description" type="text" class="form-control"
                                               placeholder="add skill" value="">
                                    </li>
                                    <li>
                                        <button type="button" class="Button RedButton Button18" style="font-size:22px;">
                                            add
                                            labels
                                        </button>
                                        <a href="javascript:void(0);">Recommended labels</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="mycard-plus" style="display:none;">
                                <div class="default-tag tagbtn">
                                    <div class="clearfix">
                                        <?php
                                        $skills = new SkillsCollection();
                                        $skills_array = $skills->getGeneralSkills();
                                        foreach ($skills_array as $skill) {
                                            echo '<a value="' . htmlspecialchars($skill['skill_id']) . '" title="' . htmlspecialchars($skill['skill_name']) . '" href="javascript:void(0);">';
                                            echo '<span>' . htmlspecialchars($skill['skill_name']) . '</span> <em></em>';
                                            echo '</a>';
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript" src="../js/lanrenzhijia.js"></script>
                            <link href="../css/lanrenzhijia.css" type="text/css" rel="stylesheet"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-2 col-lg-offset-2 col-md-offset-4 col-sm-offset-4 col-xs-offset-2">
                            <a class="btn btn-danger" data-toggle="modal" style="width: 90%; margin-top: 10px;"
                               data-target="#myModal_exchange">Change password
                            </a>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-lg-2 col-lg-offset-2 col-md-offset-4 col-sm-offset-4 col-xs-offset-2">
                            <button type="submit" class="btn btn-warning" name="submit">Save changes</button>
                        </div>
                    </div>

                    <!-- Get user id to post so we can update it-->
                    <input type="hidden" name="user_id" value="<?php echo $_user->getUserId() ?>">
            </form>
        </main>
    </div>

    <!-- Modal -->
    <div id="myModal_exchange" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change password</h4>
                </div>
                <form role="form" action="../classes/routers/change_password_router.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class=" control-label">Old Password</label>
                            <div class="col-lg-6  col-sm-5 col-xs-7">
                                <input type="password" class="form-control" id="old_password"
                                       name="old_password"
                                       placeholder="old password"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">New Password</label>
                            <div class="col-lg-6  col-sm-5 col-xs-7">
                                <input type="password" class="form-control" id="new_password"
                                       name="new_password"
                                       placeholder="new password"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">New Password</label>
                            <div class="col-lg-6  col-sm-5 col-xs-7">
                                <input type="password" class="form-control" id="new_password_repeat"
                                       name="new_password_repeat"
                                       placeholder="repeat new password"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default" name="change_password_submit">Save
                        </button>

                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<!-- footer begin -->
<footer id="footer" class="footer">
    <?php include("share_page/footer.html"); ?></footer>
</body>
