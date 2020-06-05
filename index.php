<?PHP
require_once('utils/XHTML_functions.php');

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['logged']);
    unset($_SESSION['loggedName']);
    header("location: index.php");
}
?>
<html>
<?php
echo html_head("Climb Training");
?>
    <body class="bg-home-page">
    <?php
    echo html_navbar();
    ?>
    </body>
</html>
