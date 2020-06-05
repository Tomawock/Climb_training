<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}
$dl = new DataLayer();
if (isset($_GET['id'])) {
    $exercise = $dl->findCompleteExerciseById($_GET['id']);
}

if (isset($_GET['confirm'])) {
    if (isset($_GET['id'])) {
        $tools = $dl->getAllTools();
        //set up dependecies of exercise
        foreach ($tools as $actualTool) {   
            //presente nell selezione della pagina e non preente sul db allora lo aggiungo
            if ($dl->isPresentExerciseToToll($_GET['id'], $actualTool->getId())){
                //non preente nella selezione della pagina ma è preente nel db
                $dl->deleteExerciseToToll($_GET['id'], $actualTool->getId());
            }         
        }
        $dl->deleteExerciseToPhotoRecursive($_GET['id']);
        $dl->deleteExercise($_GET['id']);
    }
    header("location: exercisesList.php");
}
?>
<html>
    <?php
    echo html_head("Exercise :: Delete Exercise");
    ?>
    <body>
        <?php
        echo html_navbar();
        ?>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>
                <li><a href="exercisesList.php">Exercises List</a></li>
                <li><a class="active">Delete Exercise</a></li>
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
                            echo "Delete ".$exercise->getName();
                        echo '</h1>';
                        }
                        ?>
                    </header>
                    <p class='lead'>
                        Deleting Exercise. Confirm?
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
                            <p><a class="btn btn-default" href="exercisesList.php"><span class='glyphicon glyphicon-log-out'></span> Revert</a></p>
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
                            echo '<p><a class="btn btn-danger" href="deleteExercise.php?id=' . $_GET['id'] . '&confirm=confirm"><span class=\'glyphicon glyphicon-trash\'></span> Delete</a></p>';
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>
