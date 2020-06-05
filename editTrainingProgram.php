<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();
$exerciseList = $dl->listExercisesComplete();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['id'])) {
        // on edit state   
        $dl->editTrainingProgram($_POST['id'], $_POST['trainingProgramTitle'], $_POST['trainingProgramDescription'], $_POST['trainingProgramTimeMin'], $_POST['trainingProgramTimeMax']);

        foreach ($exerciseList as $ex) {
            //presente nell selezione della pagina e non preente sul db allora lo aggiungo
            if (isset($_POST['exercise' . $ex->getId()]) && !$dl->isPresentExerciseToTrainingprogram($ex->getId(), $_POST['id'])) {

                $dl->createExerciseToTrainingprogram($ex->getId(), $_POST['id']);
            } else if (!isset($_POST['exercise' . $ex->getId()]) && $dl->isPresentExerciseToTrainingprogram($ex->getId(), $_POST['id'])) {
                //non preente nella selezione della pagina ma è preente nel db

                $dl->deleteExerciseToTrainingprogram($ex->getId(), $_POST['id']);
            }
        }
        //redirect
        header("location: trainingProgramList.php");
    } else {
        // on create state
        echo $_POST['trainingProgramTitle'];
        $dl->createTrainingProgram($_POST['trainingProgramTitle'], $_POST['trainingProgramDescription'], $_POST['trainingProgramTimeMin'], $_POST['trainingProgramTimeMax']);
        $idTp = $dl->getLastIdTrainingprogram();

        foreach ($exerciseList as $ex) {
            //presente nell selezione della pagina e non preente sul db allora lo aggiungo
            if (isset($_POST['exercise' . $ex->getId()]) && !$dl->isPresentExerciseToTrainingprogram($idTp, $ex->getId())) {
                $dl->createExerciseToTrainingprogram($ex->getId(), $idTp);
            } else if (!isset($_POST['exercise' . $ex->getId()]) && $dl->isPresentExerciseToTrainingprogram($idTp, $ex->getId())) {
                //non preente nella selezione della pagina ma è preente nel db
                $dl->deleteExerciseToTrainingprogram($ex->getId(), $idTp);
            }
        }
        //redirect
        header("location: trainingProgramList.php");
    }
}


if (isset($_GET['id'])) {
    $tp = $dl->findCompleteTrainingProgramById($_GET['id']);
}
?>
<html>
    <?php
    if (isset($_GET['id'])) {
        echo html_head("Training Program :: Edit");
    } else {
        echo html_head("Training Program :: New");
    }
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
                <?php
                if (isset($_GET['id'])) {
                    //edit case
                    echo '<li><a class="active">Edit Training Program</a></li>';
                } else {
                    echo '<li><a class="active">New Training Program</a></li>';
                }
                ?>
            </ul>
        </div>
        <!-- Page Initial Name -->
        <div class="container">
            <header class="header-sezione text-center">
                <?php
                if (isset($_GET['id'])) {
                    //edit case
                    echo '<h1>Edit Training Program</h1>';
                } else {
                    echo '<h1>New Training Program</h1>';
                }
                ?>              
            </header>
        </div>

        <div class="container">
            <div class="row">
                <div class='col-md-12'>
                    <form class="form-horizontal" name="trainingProgram" method="post" action="#">
                        <!-- Title of the Training Program-->
                        <div class="form-group">
                            <label for="trainingProgramTitle" class="col-md-2">Title</label>
                            <div class="col-md-10">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<input class="form-control" type="text" id="trainingProgramTitle" name="trainingProgramTitle" placeholder="Training Program Title" value="' . $tp->getTitle() . '">';
                                } else {
                                    echo '<input class="form-control" type="text" id="trainingProgramTitle" name="trainingProgramTitle" placeholder="Training Program Title">';
                                }
                                ?>        
                            </div>
                        </div>
                        <!-- Description-->
                        <div class="form-group">
                            <label for="trainingProgramDescription" class="col-md-2">Description</label>
                            <div class="col-md-10">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<textarea class="form-control" rows="4" id="trainingProgramDescription" name="trainingProgramDescription">' . $tp->getDescription() . '</textarea>';
                                } else {
                                    echo '<textarea class="form-control" rows="4" id="trainingProgramDescription" name="trainingProgramDescription" placeholder="Complete Training Program Description"></textarea>';
                                }
                                ?>      

                            </div>
                        </div>
                        <!-- Time Averange fo the completment of the Training program -->
                        <div class="form-group">
                            <label for="trainingProgramTime" class="col-md-2">Time</label>
                            <label for="trainingProgramTimeMin" class="col-md-1">Min</label>
                            <div class="col-md-2">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<input type="time" id="trainingProgramTimeMin" name="trainingProgramTimeMin" class="form-control" min="00:00:00" max="24:59:59" value="' . $tp->getTimeMin() . '" required>';
                                } else {
                                    echo '<input type="time" id="trainingProgramTimeMin" name="trainingProgramTimeMin" class="form-control" min="00:00:00" max="24:59:59" value="00:00:00" required>';
                                }
                                ?>
                            </div>
                            <label for="trainingProgramTimeMax" class="col-md-1">Max</label>
                            <div class="col-md-2">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<input type="time" id="trainingProgramTimeMax" name="trainingProgramTimeMax" class="form-control" min="00:00:00" max="24:59:59" value="' . $tp->getTimeMax() . '" required>';
                                } else {
                                    echo '<input type="time" id="trainingProgramTimeMax" name="trainingProgramTimeMax" class="form-control" min="00:00:00" max="24:59:59" value="00:00:00" required>';
                                }
                                ?>
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
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Search Name">
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-link" type="submit"><span class="glyphicon glyphicon-search"></span> Submit</a>
                                </div>

                                <div class="col-md-1">
                                    <label for="orderTrainingProgramReps" class="btn btn-default"><span class="glyphicon glyphicon-arrow-up"></span> Reps</label>
                                    <input id="orderTrainingProgramReps" type="submit" value='orderReps' class="hidden"/>      
                                </div>
                                <div class="col-md-1">
                                    <label for="orderTrainingProgramSetss" class="btn btn-default"><span class="glyphicon glyphicon-arrow-up"></span> Sets</label>
                                    <input id="orderTrainingProgramSets" type="submit" value='orderSets' class="hidden"/>      
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2 text-center">Name</th>
                                            <th class="col-md-1 text-center">Reps</th>
                                            <th class="col-md-1 text-center">Sets</th>
                                            <th class="col-md-2 text-center">Rest</th>
                                            <th class="col-md-2 text-center">Overweight</th>
                                            <th class="col-md-2 text-center">Tags</th>
                                            <th class="col-md-1 text-center">Tools</th>
                                            <th class="col-md-1 text-center">Selected</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (isset($_GET['id'])) {

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

                                                $result = '<input type="checkbox" name="exercise' . $exercise->getId() . '">';
                                                foreach ($tp->getExercies() as $selectedExercise) {
                                                    if ($selectedExercise->getId() == $exercise->getId()) {
                                                        $result = '<input type="checkbox" name="exercise' . $exercise->getId() . '" checked>';
                                                    }
                                                }

                                                echo '<td><div style="height:50px; overflow:hidden">' . $result . '</div></td>';
                                                echo '</tr>';
                                            }
                                        } else {
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

                                                $result = '<input type="checkbox" name="exercise' . $exercise->getId() . '">';
                                                echo '<td><div style="height:50px; overflow:hidden">' . $result . '</div></td>';

                                                echo '</tr>';
                                            }
                                        }
                                        ?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Buttons confirm-->
                        <?php
                        if (isset($_GET['id'])) {
                            echo '<input type="hidden" name="id" value="' . $tp->getId() . '"/>';
                            echo '<label for="mySubmit" class="btn btn-primary btn-large btn-block"><span class="glyphicon glyphicon-floppy-save"></span> Save</label>';
                            echo '<input id="mySubmit" type="submit" value=\'Save\' class="hidden"/>';
                        } else {
                            echo '<label for="mySubmit" class="btn btn-primary btn-large btn-block"><span class="glyphicon glyphicon-floppy-save"></span> Create</label>';
                            echo '<input id="mySubmit" type="submit" value=\'Create\' class="hidden"/>';
                        }
                        ?>                         
                        <!-- Buttons cancel-->
                        <a href="trainingProgramList.php" class="btn btn-danger btn-large btn-block"><span class="glyphicon glyphicon-log-out"></span> Cancel</a>                         
                    </form>
                </div>   
            </div>
        </div>
    </div>
</div>
</body>
</html>
