<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}
$dl = new DataLayer();

//GRAVE
$user=$dl->getUserbyUsername($_SESSION['loggedName']);

?>
<html>
    <?php
    echo html_head("Climbing Training :: Account");
    ?>
    <body>
        <?php
        echo html_navbar();
        ?>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>
                <li><a class="active">Account</a></li>
            </ul>
        </div>
        <!-- Page Initial Name -->
        <div class="container">
            <header class="header-sezione">
                <h1>
                    Account
                </h1>
            </header>
        </div>
        <!-- Account Details -->
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-default ">
                        <!-- Default panel contents -->
                        <div class="panel-heading text-center panel-relative"><h2 class="panel-title"><strong>Details</strong></h2></div>
                        <div class="panel-body">
                            <div class="container">
                                <div class="row">
                                    <label class="col-md-6">Username</label>
                                    <label class="col-md-6"><?php echo $user->getUsername(); ?></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-6">Name</label>
                                    <label class="col-md-6"><?php echo $user->getName();?></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-6">Surname</label>
                                    <label class="col-md-6"><?php echo $user->getSurname();?></label>
                                </div>
                                <div class="row">
                                    <label class="col-md-6">E-mail</label>
                                    <label class="col-md-6"><?php echo $user->getEmail();?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>

