<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();

$user = $dl->getUserbyUsername($_SESSION['loggedName']);
$tps = $dl->getMyTrainingprogramsComplete($user->getUsername());

if (isset($_GET['remove'])) {
    if (isset($_GET['id'])) {
        
        $dl->deleteTrainingProgramToUser($user->getId(),$_GET['id']);
        header("location: accountTrainingProgramList.php");
    }
}
?>
<html>
    <?php
    echo html_head("Training Program :: List");
    ?>
    <body>
        <?php
        echo html_navbar();
        ?>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>
                <li><a class="active">Personal Training Program</a></li>
            </ul>
        </div>
        <!-- Page Initial Name -->
        <div class="container">
            <header class="header-sezione">
                <h1>
                    <?php echo $user->getName() ?> Training Program
                </h1>
            </header>
        </div>
        <!-- Body effettivo-->
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <form  class="form-horizontal" name="searchForm" method="post" action="#"> 
                        <div class="input-group">
                            <span class="input-group-btn">   
                                <button class="btn btn-link" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                            <input type="text" class="form-control" placeholder="Search by Title" name="search" id="search">     
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-3">Title</th>
                                    <th class="col-md-5">Description</th>
                                    <th class="col-md-1"></th>
                                    <th class="col-md-1"></th> 
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($tps as $tp) {
                                    echo '<tr>';
                                    echo '<td>' . $tp->getTitle() . '</td>';
                                    echo '<td>' . $tp->getDescription() . '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-danger btn-block" href="accountTrainingProgramList.php?id=' . $tp->getId() . '&remove=remove"><span class="glyphicon glyphicon-trash"></span> Remove</a>';
                                    echo '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-success btn-block" href="playTrainingProgram.php?id=' . $tp->getId() . '"><span class="glyphicon glyphicon-play"></span> Execute</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>    
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>