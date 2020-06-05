<?php

/*
 * Climb Training XHTML funcionality & constants
 */
define('EXERCISEREPSMIN', 50);
define('EXERCISEREPSMAX', 50);
define('EXERCISESETSMIN', 50);
define('EXERCISESETSMAX', 50);
define('EXERCISEOVERWEIGHTMIN', 50);
define('EXERCISEOVERWEIGHTMAX', 50);
define('EXERCISEOVERWEIGHTUNIT', array('Kg', '%'));

define('PHOTODIRECTORY', "upload/");

function html_head($titolo, $style = 'style.css') {
    $result = '  <head>';
    $result .= '    <meta charset="UTF-8">';
    $result .= '    <title>' . $titolo . '</title>';
    $result .= '    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">';
    $result .= '    <!-- Fogli di stile -->';
    $result .= '    <link rel="stylesheet" href="css/bootstrap.css">';
    $result .= '    <link rel="stylesheet" href="css/' . $style . '">';
    $result .= '    <!-- jQuery e plugin JavaScript -->';
    $result .= '    <script src="http://code.jquery.com/jquery.js"></script>';
    $result .= '    <script src="js/bootstrap.min.js"></script>';
    $result .= '  </head>';

    return $result;
}

function html_navbar() {
    $result = '<!-- Navbar -->';
    $result .= '    <nav class="navbar navbar-inverse navbar-fixed-top">';
    $result .= '        <div class="container">';
    $result .= '            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">';
    $result .= '                <span class="icon-bar"></span>';
    $result .= '                <span class="icon-bar"></span>';
    $result .= '                <span class="icon-bar"></span>';
    $result .= '            </button>';
    $result .= '            <!-- da qua inizia la ver navbarprima serviva solo nel cao in cui lo schermo è picolo -->';
    $result .= '            <div class="collapse navbar-collapse" id="myNavbar">';
    $result .= '                <ul class="nav navbar-nav">';
    $result .= '                    <li><a href="index.php">Home</a></li>';
    $result .= '                    <li class="dropdown">';
    $result .= '                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Training<b class="caret"></b></a>';
    $result .= '                        <ul class="dropdown-menu">';
    $result .= '                            <li><a href="account.php">Account</a></li>';
    $result .= '                            <li><a href="accountTrainingProgramList.php">Personal Training Program</a></li>';
    $result .= '                            <li><a href="accountStatistic.php">History and Statistics</a></li>';
    $result .= '                        </ul>';
    $result .= '                    </li>';
    $result .= '                    <li class="dropdown">';
    $result .= '                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Training<b class="caret"></b></a>';
    $result .= '                        <ul class="dropdown-menu">';
    $result .= '                            <li><a href="exercisesList.php">Exercise List</a></li>';
    $result .= '                            <li><a href="trainingProgramList.php">Training Program List</a></li>';
    $result .= '                        </ul>';
    $result .= '                    </li>';
    $result .= '                </ul>';
    $result .= '                <ul class="nav navbar-nav navbar-right">';

    if (isset($_SESSION['logged'])) {
        $result .= '<li><a><i>Welcome ' . $_SESSION['loggedName'] . '</i></a></li>';
        $result .= '<li><a href="' . $_SERVER["PHP_SELF"] . '?logout=out">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>';
    } else {
        $result .= '<li><a href="loginRegister.php"><span class="glyphicon glyphicon-user"></span> Log in</a></li>';
    }

    $result .= '                </ul>';
    $result .= '            </div>';
    $result .= '        </div>';
    $result .= '    </nav>';
    return $result;
}

function uploadFile($fileName) {

// verifichiamo che il file è stato caricato  
    if (!is_uploaded_file($_FILES["" . $fileName . ""]["tmp_name"]) or $_FILES["" . $fileName . ""]["error"] > 0) {
        return false;
        echo 'Si sono verificati problemi nella procedura di upload!';
    }

// verifichiamo che il tipo è fra quelli consentiti  
    else if (!is_dir(PHOTODIRECTORY)) {
        return false;
        echo 'La cartella in cui si desidera salvare il file non esiste!';
    }

// verifichiamo che la cartella di destinazione abbia i permessi di scrittura  
    else if (!is_writable(PHOTODIRECTORY)) {
        return false;
        echo "La cartella in cui fare l'upload non ha i permessi!";
    }
// verifichiamo il successo della procedura di upload nella cartella settata  
    else if (!move_uploaded_file($_FILES["" . $fileName . ""]["tmp_name"], PHOTODIRECTORY . $_FILES["" . $fileName . ""]["name"])) {
        return false;
        echo 'Ops qualcosa è andato storto nella procedura di upload!';
    }
// altrimenti significa che è andato tutto ok  
    else {
        return true;
    }
    return false;
}

function userLoggedControl() {

    session_start();
    if (!isset($_SESSION['logged'])) {
        
        header("location: loginRegister.php");
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['logged']);
        unset($_SESSION['loggedName']);
        header("location: index.php");
    }
}

?>