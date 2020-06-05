<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();
$myTrainingprograms = $dl->getMyTrainingprogramsId($_SESSION['loggedName']);


if (isset($_POST['search'])) {
    //caso nel quale ho cliccato il pulsante search
} else
if (isset($_GET['addId'])) {
    //caso nel quale aggiungo un elemento alla lista delle mie schede
    $dl->addTrainingprogramToUser($_GET['addId'], $_SESSION['loggedName']);
    header('location: trainingProgramList.php');
} else {
    $tpList = $dl->listTrainingProgramSimple();
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
                <li><a class="active">Training Program List</a></li>
            </ul>
        </div>
        <!-- Page Initial Name -->
        <div class="container">
            <header class="header-sezione">
                <h1>
                    Training Program List 
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
                <div class="col-md-offset-7 col-md-2">
                    <a class="btn btn-success btn-block" href="editTrainingProgram.php"><span class="glyphicon glyphicon-new-window"></span> New Training Program</a>
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
                                    <th class="col-md-1"></th>
                                    <th class="col-md-1"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($tpList as $tp) {
                                    echo '<tr>';
                                    echo '<td>' . $tp->getTitle() . '</td>';
                                    echo '<td>' . $tp->getDescription() . '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-info btn-block" href="showTrainingProgram.php?id=' . $tp->getId() . '"><span class="glyphicon glyphicon-eye-open"></span> Show</a>';
                                    echo '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-primary btn-block" href="editTrainingProgram.php?id=' . $tp->getId() . '"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
                                    echo '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-danger btn-block" href="deleteTrainingProgram.php?id=' . $tp->getId() . '"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                                    echo '</td>';
                                    $deactive = false;
                                    foreach ($myTrainingprograms as $myTp) {
                                        if ($myTp == $tp->getId()) {
                                            $deactive = true;
                                        }
                                    }
                                    if ($deactive == true) {
                                        echo '<td>';
                                        echo '<a class="btn btn-success btn-block" href="trainingProgramList.php?addId=' . $tp->getId() . '"  disabled><span class="glyphicon glyphicon-plus"></span> Add</a>';
                                        echo '</td>';
                                    } else {
                                        echo '<td>';
                                        echo '<a class="btn btn-success btn-block" href="trainingProgramList.php?addId=' . $tp->getId() . '"><span class="glyphicon glyphicon-plus"></span> Add</a>';
                                        echo '</td>';
                                    }

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