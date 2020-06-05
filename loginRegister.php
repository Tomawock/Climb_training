<?PHP
require_once('utils/XHTML_functions.php');

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["login-submit"])) {
        if ($dl->validUser($_POST["username"], $_POST["password"])) {
            session_start();
            $_SESSION['logged'] = true;
            $_SESSION['loggedName'] = $_POST["username"];
            if (!empty($_POST["remember"])) {
                setcookie("username_login", $_POST["username"], time() + (60 * 60));
                setcookie("password_login", $_POST["password"], time() + (60 * 60));
            } else {
                if (isset($_COOKIE["username_login"])) {
                    setcookie("username_login", "", time() - 1);
                    setcookie("password_login", "", time() - 1);
                }
            }
            header("location: index.php");
        } else {
            header("location: authErrorPage.php");
        }
    } elseif (isset($_POST["register-submit"])) {
        
        $dl->addUser($_POST["name"], $_POST["surname"], $_POST["username"], $_POST["password"], $_POST["email"]);
    }
}
?>
<html>
    <?php
    echo html_head("Climb Training");
    ?>
    <body>

        <div class="container">
            <div class="row" style="margin-top: 4em;">
                <div class="col-md-6 col-md-offset-3">
                    <div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#login-form" data-toggle="tab">Login</a></li>
                            <li><a href="#register-form" data-toggle="tab">Register</a></li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="login-form">
                                <form id="login-form" action="#" method="post" style="margin-top: 2em;">
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php if (isset($_COOKIE["username_login"])) {echo $_COOKIE["username_login"];} ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" value="<?php if (isset($_COOKIE["password_login"])) {echo $_COOKIE["password_login"];} ?>">
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="checkbox" name="remember" <?php if (isset($_COOKIE["username_login"])) { ?> checked <?php } ?>>
                                        <label for="remember"> Remember Me</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login-submit" class="form-control btn btn-primary" value="Log In">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="text-center">
                                            <a href="#" class="forgot-password">Forgot Password?</a>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="register-form">
                                <form id="register-form" action="#" method="post" style="margin-top: 2em;">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="surname" class="form-control" placeholder="Surname" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="Email Address" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register-submit" class="form-control btn btn-primary" value="Register Now">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>