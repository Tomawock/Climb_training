<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();
$tools = $dl->getAllTools();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $tools = $dl->getAllTools();
    if (isset($_POST['id'])) {
        // on edit state           
        $dl->editExercise($_POST['id'],
                $_POST['exerciseName'],
                $_POST['exerciseDescription'],
                $_POST['exerciseImportantNotes'],
                $_POST['exerciseRepsMin'],
                $_POST['exerciseRepsMax'],
                $_POST['exerciseSetMin'],
                $_POST['exerciseSetMax'],
                $_POST['exerciseRestMin'],
                $_POST['exerciseRestMax'],
                $_POST['exerciseOverweightMin'],
                $_POST['exerciseOverweightMax'],
                $_POST['exerciseOverweightUnit']);

        //set up dependecies of exercise and tools
        foreach ($tools as $actualTool) {
            //presente nell selezione della pagina e non preente sul db allora lo aggiungo
            if (isset($_POST['tool' . $actualTool->getId()]) && !$dl->isPresentExerciseToToll($_POST['id'], $actualTool->getId())) {
                $dl->createExerciseToToll($_POST['id'], $actualTool->getId());
            } else if (!isset($_POST['tool' . $actualTool->getId()]) && $dl->isPresentExerciseToToll($_POST['id'], $actualTool->getId())) {
                //non preente nella selezione della pagina ma è preente nel db
                $dl->deleteExerciseToToll($_POST['id'], $actualTool->getId());
            }
        }
        //handle the combobox of selcted images FARE PRIMA QUESTO
        $exercisePhoto = $dl->findPhotoByExerciseId($_POST['id']);
        foreach ($exercisePhoto as $photoAlreadySelected) {
            //la foto era selezionata ed ora non lo è piu => devo cancellarla
            if (!isset($_POST['photo' . $photoAlreadySelected->getId()])) {
                //elimino la tabella di legame con l'esercizio
                $dl->deleteExerciseToPhoto($_POST['id'], $photoAlreadySelected->getId());
                $dl->deletePhoto($photoAlreadySelected->getId());
            }
        }

        // caso nel quale è selezionata una photo DI QUESTO 
        if (isset($_FILES['exercisePhoto'])) {
            //carica il file 
            if (uploadFile('exercisePhoto')) { //carica effettivamente il file se non lo carica non fa niente
                $dl->createPhoto(PHOTODIRECTORY . $_FILES["exercisePhoto"]["name"], $_POST['exercisePhotoDescription']);
                $idPhoto = $dl->getLastIdPhoto();
                $dl->createExerciseToPhoto($_POST['id'], $idPhoto);
            }
        }
        //NOTE se non lo si fa la query cancella il file appena caricato in qunato non risulta selezionato dalla combobox
        //redirect
        header("location: exercisesList.php");
    } else {
        // on create state
        $dl->createExercise(
                $_POST['exerciseName'],
                $_POST['exerciseDescription'],
                $_POST['exerciseImportantNotes'],
                $_POST['exerciseRepsMin'],
                $_POST['exerciseRepsMax'],
                $_POST['exerciseSetMin'],
                $_POST['exerciseSetMax'],
                $_POST['exerciseRestMin'],
                $_POST['exerciseRestMax'],
                $_POST['exerciseOverweightMin'],
                $_POST['exerciseOverweightMax'],
                $_POST['exerciseOverweightUnit']);
        //set up dependecies of exercise
        foreach ($tools as $actualTool) {
            if (isset($_POST['tool' . $actualTool->getId()])) {
                $idExercise = $dl->getLastIdExercise();
                $dl->createExerciseToToll($idExercise, $actualTool->getId());
            }
        }
        if (isset($_FILES['exercisePhoto'])) {
            //carica il file 
            if (uploadFile('exercisePhoto')) { //carica effettivamente il file
                $dl->createPhoto(PHOTODIRECTORY . $_FILES["exercisePhoto"]["name"], $_POST['exercisePhotoDescription']);
                $idPhoto = $dl->getLastIdPhoto();
                $exerciseId = $dl->getLastIdExercise();
                $dl->createExerciseToPhoto($exerciseId, $idPhoto);
            }
        }
        //redirect
        header("location: exercisesList.php");
    }
}


if (isset($_GET['id'])) {
    $exercise = $dl->findCompleteExerciseById($_GET['id']);
    $exerciseTools = $dl->findToolByExerciseId($_GET['id']);
    $exercisePhoto = $dl->findPhotoByExerciseId($_GET['id']);
}
?>
<html>
    <?php
    if (isset($_GET['id'])) {
        echo html_head("Exercise :: Edit");
    } else {
        echo html_head("Exercise :: New");
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
                <li><a href="exercisesList.php">Exercises List</a></li>
                <?php
                if (isset($_GET['id'])) {
                    //edit case
                    echo '<li><a class="active">Edit Exercise</a></li>';
                } else {
                    echo '<li><a class="active">New Exercise</a></li>';
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
                    echo '<h1>Edit Exercise</h1>';
                } else {
                    echo '<h1>New Exercise</h1>';
                }
                ?>              
            </header>
        </div>
        <div class="container">
            <div class="row">
                <div class='col-md-12'>
                    <form class="form-horizontal" name="exercise" method="post" action="#" enctype="multipart/form-data">
                        <!-- Name of the Exercise-->
                        <div class="form-group">
                            <label for="exerciseName" class="col-md-2">Name</label>
                            <div class="col-md-10">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<input class="form-control" type="text" id="exerciseName" name="exerciseName" placeholder="Exercise Name" value="' . $exercise->getName() . '">';
                                } else {
                                    echo '<input class="form-control" type="text" id="exerciseName" name="exerciseName" placeholder="Exercise Name">';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Description-->
                        <div class="form-group">
                            <label for="exerciseDescription" class="col-md-2">Description</label>
                            <div class="col-md-10">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<textarea class="form-control" rows="4" id="exerciseDescription" name="exerciseDescription" placeholder="Complete Exercise Description" >' . $exercise->getDescription() . '</textarea>';
                                } else {
                                    echo '<textarea class="form-control" rows="4" id="exerciseDescription" name="exerciseDescription" placeholder="Complete Exercise Description"></textarea>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Important Notes -->
                        <div class="form-group">
                            <label for="exerciseImportantNotes" class="col-md-2">Important Notes</label>
                            <div class="col-md-10">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<textarea class="form-control" rows="2" id="exerciseImportantNotes" name="exerciseImportantNotes" placeholder="Important Notes for correct execution of the exercise">' . $exercise->getImportantNotes() . '</textarea>';
                                } else {
                                    echo '<textarea class="form-control" rows="2" id="exerciseImportantNotes" name="exerciseImportantNotes" placeholder="Important Notes for correct execution of the exercise"></textarea>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Photo Insertion-->
                        <div class="form-group">
                            <label for="exercisePhoto" class="col-md-2"> Add Photo</label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="exercisePhotoDescription" name="exercisePhotoDescription" placeholder="Exercise Photo Description">
                            </div>
                            <div class="col-md-5">
                                <input class="form-control-file" type="file" id="exercisePhoto" name="exercisePhoto">
                            </div>
                        </div>
                        <?php
                        if (isset($_GET['id'])) {
                            if (sizeof($exercisePhoto) > 0) {
                                echo '<div class="form-group">';
                                echo '<label class="col-md-2"> Keep Photo</label>';
                                echo '  <div class="col-md-10">';

                                foreach ($exercisePhoto as $actualPhoto) {

                                    echo '<label class="checkbox-inline">';
                                    echo '       <input type="checkbox" id="photo' . $actualPhoto->getId() . '" name="photo' . $actualPhoto->getId() . '" checked>' . $actualPhoto->getDescription();
                                    echo '</label>';
                                }
                                echo '  </div>';
                                echo '</div>';
                            }
                        }
                        ?>
                        <!-- Reps -->
                        <div class="form-group">
                            <label for="exerciseRepsMin" class=" col-md-2">Reps</label>
                            <label for="exerciseRepsMin" class=" col-md-1">Min</label>
                            <div class="col-md-1">
                                <select class="form-control" id="exerciseRepsMin" name="exerciseRepsMin">
                                    <?php
                                    for ($i = 1; $i <= EXERCISEREPSMIN; $i++) {
                                        if (isset($_GET['id']) && $i == $exercise->getRepsMin()) {
                                            //edit case
                                            echo '<option selected>' . $i . '</option>';
                                        } else {
                                            echo '<option>' . $i . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <label for="exerciseRepsMax" class="col-md-1">Max</label>
                            <div class="col-md-1">
                                <select class="form-control" id="exerciseRepsMax" name="exerciseRepsMax">
                                    <?php
                                    for ($i = 1; $i <= EXERCISEREPSMAX; $i++) {
                                        if (isset($_GET['id']) && $i == $exercise->getRepsMax()) {
                                            //edit case
                                            echo '<option selected>' . $i . '</option>';
                                        } else {
                                            echo '<option>' . $i . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Sets-->
                        <div class="form-group">
                            <label for="exerciseSet" class="col-md-2">Sets</label>
                            <label for="exerciseSetMin" class="col-md-1">Min</label>
                            <div class="col-md-1">
                                <select class="form-control" id="exerciseSetMin" name="exerciseSetMin">
                                    <?php
                                    for ($i = 1; $i <= EXERCISESETSMIN; $i++) {
                                        if (isset($_GET['id']) && $i == $exercise->getSetMin()) {
                                            //edit case
                                            echo '<option selected>' . $i . '</option>';
                                        } else {
                                            echo '<option>' . $i . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <label for="exerciseSetMax" class="col-md-1">Max</label>
                            <div class="col-md-1">
                                <select class="form-control" id="exerciseSetMax" name="exerciseSetMax">
                                    <?php
                                    for ($i = 1; $i <= EXERCISESETSMAX; $i++) {
                                        if (isset($_GET['id']) && $i == $exercise->getSetMax()) {
                                            //edit case
                                            echo '<option selected>' . $i . '</option>';
                                        } else {
                                            echo '<option>' . $i . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>   
                        <!-- Overweight-->
                        <div class="form-group">
                            <label for="exerciseOverweight" class="col-md-2">Overweight</label>
                            <label for="exerciseOverweightMin" class="col-md-1">Min</label>
                            <div class="col-md-1">
                                <select class="form-control" id="exerciseOverweightMin" name="exerciseOverweightMin">
                                    <?php
                                    for ($i = 0; $i <= EXERCISEOVERWEIGHTMIN; $i++) {
                                        if (isset($_GET['id']) && $i == $exercise->getOverweightMin()) {
                                            //edit case
                                            echo '<option selected>' . $i . '</option>';
                                        } else {
                                            echo '<option>' . $i . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <label for="exerciseOverweightMax" class="col-md-1">Max</label>
                            <div class="col-md-1">
                                <select class="form-control" id="exerciseOverweightMax" name="exerciseOverweightMax">
                                    <?php
                                    for ($i = 0; $i <= EXERCISEOVERWEIGHTMAX; $i++) {
                                        if (isset($_GET['id']) && $i == $exercise->getOverweightMax()) {
                                            //edit case
                                            echo '<option selected>' . $i . '</option>';
                                        } else {
                                            echo '<option>' . $i . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <label for="exerciseOverweightType" class="col-md-1">Unit</label>
                            <div class="col-md-1">
                                <select class="form-control" id="exerciseOverweightUnit" name="exerciseOverweightUnit">
                                    <?php
                                    foreach (EXERCISEOVERWEIGHTUNIT as $value) {
                                        if (isset($_GET['id']) && $value == $exercise->getOverweightUnit()) {
                                            //edit case
                                            echo '<option selected>' . $value . '</option>';
                                        } else {
                                            echo '<option>' . $value . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div> 
                        </div>
                        <!-- Rest-->
                        <div class="form-group">
                            <label for="exerciseRest" class="col-md-2">Rest</label>
                            <label for="exerciseRestMin" class="col-md-1">Min</label>
                            <div class="col-md-2">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<input type="time" id="exerciseRestMin" name="exerciseRestMin" class="form-control" min="00:00:00" max="24:59:59" value="' . $exercise->getRestMin() . '" required>';
                                } else {
                                    echo '<input type="time" id="exerciseRestMin" name="exerciseRestMin" class="form-control" min="00:00:00" max="24:59:59" value="00:00:00" required>';
                                }
                                ?>
                            </div>

                            <label for="exerciseRestMax" class="col-md-1">Max</label>
                            <div class="col-md-2">
                                <?php
                                if (isset($_GET['id'])) {
                                    //edit case
                                    echo '<input type="time" id="exerciseRestMax" name="exerciseRestMax" class="form-control" min="00:00:00" max="24:59:59" value="' . $exercise->getRestMax() . '" required>';
                                } else {
                                    echo '<input type="time" id="exerciseRestMax" name="exerciseRestMax" class="form-control" min="00:00:00" max="24:59:59" value="00:00:00" required>';
                                }
                                ?>
                            </div>  
                        </div>
                        <!-- exercise Tags with JS TODO
                        <div class="form-group">
                            <label for="exerciseTags" class="col-md-2">Tags</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="" data-role="tagsinput" id="exerciseTags"/>
                            </div>
                        </div>
                        -->
                        <!-- Tags-->
                        <div class="form-group">
                            <label for="exerciseTags" class="col-md-2">Tags</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="exerciseTags" name="exerciseTags" placeholder="Power Endurance FingerStregth ...">
                            </div>
                        </div>
                        <!-- Tecnical Tools-->
                        <div class="form-group">
                            <label for="exerciseTecnicalTools" class="col-md-2">Tecnical Tools</label>
                            <div class="col-md-10" class="form-control">
                                <?php
                                foreach ($tools as $actualTool) {
                                    if (isset($_GET['id']) && $actualTool->isInside($exerciseTools)) {
                                        //edit case
                                        echo '<label class="checkbox-inline">';
                                        echo '       <input type="checkbox" id="tool' . $actualTool->getId() . '" name="tool' . $actualTool->getId() . '" checked>' . $actualTool->getName() . '';
                                        echo '</label>';
                                    } else {
                                        echo '<label class="checkbox-inline">';
                                        echo '       <input type="checkbox" id="tool' . $actualTool->getId() . '" name="tool' . $actualTool->getId() . '">' . $actualTool->getName() . '';
                                        echo '</label>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Buttons confirm-->
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo '<input type="hidden" name="id" value="' . $exercise->getId() . '"/>';
                                    echo '<label for="mySubmit" class="btn btn-primary btn-large btn-block"><span class="glyphicon glyphicon-floppy-save"></span> Save</label>';
                                    echo '<input id="mySubmit" type="submit" value=\'Save\' class="hidden"/>';
                                } else {
                                    echo '<label for="mySubmit" class="btn btn-primary btn-large btn-block"><span class="glyphicon glyphicon-floppy-save"></span> Create</label>';
                                    echo '<input id="mySubmit" type="submit" value=\'Create\' class="hidden"/>';
                                }
                                ?>                     
                            </div>
                        </div>
                        <!-- Buttons cancel-->
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a href="exercisesList.php" class="btn btn-danger btn-large btn-block"><span class="glyphicon glyphicon-log-out"></span> Cancel</a>                         
                            </div>
                        </div>                       
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
