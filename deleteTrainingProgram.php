<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}
$dl = new DataLayer();
if (isset($_GET['id'])) {
    $tp = $dl->findCompleteTrainingProgramById($_GET['id']);
}

if (isset($_GET['confirm'])) {
    if (isset($_GET['id'])) {
        $tp = $dl->findCompleteTrainingProgramById($_GET['id']);
        foreach ($tp->getExercies() as $ex){
            $dl->deleteExerciseToTrainingprogram($ex->getId(), $tp->getId());
        }
        
        $dl->deleteTrainingProgramToAllUser($tp->getId());
        $dl->deleteTrainingProgram($tp->getId());   
    }
    header("location: trainingProgramList.php");
}
?>
<html>
    <?php
    echo html_head("Training Program :: Delete");
    ?>
    <body>
        <?php
        echo html_navbar();
        ?>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>
                <li><a href="trainingProgramList.php">Training Program List</a></li>
                <li><a class="active">Delete Training Program</a></li>
            </ul>
        </div>
        <!-- Page Initial Name -->    
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <header>
                        <?php
                        if (isset($_GET['id'])) {
                        echo '<h1>';
                            echo "Delete ".$tp->getTitle();
                        echo '</h1>';
                        }
                        ?>
                    </header>
                    <p class='lead'>
                        Deleting Training program. Confirm?
                    </p>
                </div>
            </div>
        </div>

        <div class="container text-center">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class='panel-heading'>
                            Revert
                        </div>
                        <div class='panel-body'>
                            <p>The exercise <strong>will not be removed</strong> from the data base</p>
                            <p><a class="btn btn-default" href="trainingProgramList.php"><span class='glyphicon glyphicon-log-out'></span> Revert</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class='panel-heading'>
                            Confirm
                        </div>
                        <div class='panel-body'>
                            <p>The exercise <strong>will be permanently removed</strong> from the data base</p>
                            <?php
                            echo '<p><a class="btn btn-danger" href="deleteTrainingProgram.php?id=' . $_GET['id'] . '&confirm=confirm"><span class=\'glyphicon glyphicon-trash\'></span> Delete</a></p>';
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>
