<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['id'])) {
        $tp = $dl->findCompleteTrainingProgramById($_GET['id']);
        $exerciseList = $tp->getExercies();
        $user = $dl->getUserbyUsername($_SESSION['loggedName']);
        foreach ($exerciseList as $ex) {
            if (isset($_POST['executedReps' . $ex->getId()]) && isset($_POST['executedSets' . $ex->getId()]) && isset($_POST['executedNotes' . $ex->getId()])) {
                if ($_POST['executionDate'] == '')
                    $date = date("Y-m-d");
                else
                    $date = $_POST['executionDate'];

                $dl->createUserTrainingProgramExecution($ex->getId(), $_POST['id'], $user->getId(), $_POST['executedReps' . $ex->getId()],
                        $_POST['executedSets' . $ex->getId()], $date, $_POST['executedNotes' . $ex->getId()]);
            }
        }
        header("location: accountTrainingProgramList.php");
    }
}

if (isset($_GET['id'])) {
    $tp = $dl->findCompleteTrainingProgramById($_GET['id']);
    $exerciseList = $tp->getExercies();
}
?>
<html>
    <?php
    echo html_head("Training Program :: Execute");
    ?>
    <body>
        <?php
        echo html_navbar();
        ?>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>
                <li><a href="accountTrainingProgramList.php">Personal Training Program</a></li>
                <li><a class="active">Execute</a></li>      
            </ul>
        </div>
        <!-- Page Initial Name -->
        <div class="container">
            <header class="header-sezione text-center">
                <h1>Execute Training Program</h1>             
            </header>
        </div>

        <div class="container">
            <div class="row">
                <div class='col-md-12'>
                    <form class="form-horizontal" name="trainingProgram" method="post" action="#">
                        <div class="form-group">
                            <label for="executionDate" class="col-md-2">Date of execution</label>
                            <div class="col-md-10">
                                <input type="date" class="form-control" id="executionDate" name="executionDate" value="<?php echo date("d/m/Y"); ?>">
                            </div>
                        </div>
                        <!-- lista di tutti gli esercizi disponibili con ceckbox associate-->
                        <!--tabella con ricerca-->
                        <div class="panel panel-default ">
                            <!-- Default panel contents -->
                            <div class="panel-heading text-center panel-relative">
                                <h2 class="panel-title">
                                    <strong>Exercises</strong>
                                </h2>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th class="col-md-2 text-center">Name</th>
                                                <th class="col-md-1 text-center">Reps</th>
                                                <th class="col-md-1 text-center">Sets</th>
                                                <th class="col-md-2 text-center">Rest</th>
                                                <th class="col-md-1 text-center">Overweight</th>
                                                <th class="col-md-2 text-center">Tags</th>
                                                <th class="col-md-1 text-center">Tools</th>
                                                <th class="col-md-1 text-center">Reps Done</th>
                                                <th class="col-md-1 text-center">Sets Done</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            foreach ($exerciseList as $exercise) {
                                                echo '<tr>';
                                                echo '<td><div style="height:50px; overflow:hidden">' . $exercise->getName() . '</div></td>';
                                                echo '<td><div style="height:50px; overflow:hidden">' . $exercise->getRepsMin() . ' - ' . $exercise->getRepsMax() . '</div></td>';
                                                echo '<td><div style="height:50px; overflow:hidden">' . $exercise->getSetMin() . ' - ' . $exercise->getSetMax() . '</div></td>';
                                                echo '<td><div style="height:50px; overflow:hidden">' . $exercise->getRestMin() . ' - ' . $exercise->getRestMax() . '</div></td>';
                                                echo '<td><div style="height:50px; overflow:hidden">' . $exercise->getOverweightMin() . ' - ' . $exercise->getOverweightMax() . ' ' . $exercise->getOverweightUnit() . '</div></td>';
                                                echo '<td><div style="height:50px; overflow:hidden"> TODO TAGS </div></td>';
                                                $exerciseTools = $dl->findToolByExerciseId($exercise->getId());
                                                $result = "";
                                                foreach ($exerciseTools as $tool) {
                                                    $result .= $tool->getName();
                                                    $result .= ' ';
                                                }
                                                echo '<td><div style="height:50px; overflow:hidden">' . $result . '</div></td>';

                                                echo '<td><div style="height:50px; overflow:hidden">';
                                                echo '<select class="form-control" id="executedReps' . $exercise->getId() . '" name="executedReps' . $exercise->getId() . '">';
                                                for ($i = 0; $i <= EXERCISEREPSMAX; $i++) {
                                                    echo '<option>' . $i . '</option>';
                                                }
                                                echo '</select>';
                                                echo '</div></td>';
                                                echo '<td><div style="height:50px; overflow:hidden">';
                                                echo '<select class="form-control" id="executedSets' . $exercise->getId() . '" name="executedSets' . $exercise->getId() . '">';
                                                for ($i = 0; $i <= EXERCISESETSMAX; $i++) {
                                                    echo '<option>' . $i . '</option>';
                                                }
                                                echo '</select>';
                                                echo '</div></td>';
                                                echo '</tr>';

                                                echo '<tr>';
                                                echo '<td colspan="9">';
                                                echo '<textarea class="form-control" rows="1" id="executedNotes' . $exercise->getId() . '" name="executedNotes' . $exercise->getId() . '" placeholder="Notes regardings exercise: ' . $exercise->getName() . '"></textarea>';
                                                echo '</td>';

                                                echo '</tr>';
                                            }
                                            ?>    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Buttons confirm-->
                        <?php
                        echo '<input type="hidden" name="id" value="' . $tp->getId() . '"/>';
                        echo '<label for="mySubmit" class="btn btn-primary btn-large btn-block"><span class="glyphicon glyphicon-floppy-save"></span> Save</label>';
                        echo '<input id="mySubmit" type="submit" value=\'Save\' class="hidden"/>';
                        ?>                         
                        <!-- Buttons cancel-->
                        <a href="accountTrainingProgramList.php" class="btn btn-danger btn-large btn-block"><span class="glyphicon glyphicon-log-out"></span> Cancel</a>   

                    </form>
                </div>   
            </div>
        </div>
    </div>
</div>
</body>
</html>
