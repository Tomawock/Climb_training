<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();


$user = $dl->getUserbyUsername($_SESSION['loggedName']);


?>
<html>
    <?php
    echo html_head("History and Statistics ");
    ?>
    <body>
        <?php
        echo html_navbar();
        ?>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>         
                <li><a class="active">History and Statistics</a></li>
            </ul>
        </div>
        <!-- Page Initial Name --> 
        <div class="container">
            <header class="header-sezione text-center">
                <?php
                echo "<h1>";
                echo "History and Statistics<br><br>";
                echo "</h1>";
                ?>            
            </header>
        </div>

        <?php
        foreach () {
            
        }
        ?>

    </body>
</html>