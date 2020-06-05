<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();



if (isset($_POST['search'])) {
    //caso nel quale ho cliccato il pulsante search
    $exerciseList = $dl->searchExerciseByName($_POST['search']);
} else {
    //altrimenti
    $exerciseList = $dl->listExercisesSimple();
}
?>
<html>
    <?php
    echo html_head("Exercises :: List");
    ?>
    <body>
        <?php
        echo html_navbar();
        ?>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>
                <li><a class="active">Exercises List</a></li>
            </ul>
        </div>

        <!-- Page Initial Name -->
        <div class="container">
            <header class="header-sezione">
                <h1>
                    Exercises List
                </h1>
            </header>
        </div>

        <!-- Page Body -->
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <form  class="form-horizontal" name="searchForm" method="post" action="#"> 
                        <div class="input-group">
                            <span class="input-group-btn">   
                                <button class="btn btn-link" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                            <input type="text" class="form-control" placeholder="Search by Name" name="search" id="search">     
                        </div>
                    </form>
                </div>
                <div class="col-md-offset-7 col-md-2">
                    <a class="btn btn-success btn-block" href="editExercise.php"><span class="glyphicon glyphicon-new-window"></span> New Exercise</a>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive"><!-- da metter prima del tag table o ppoteri avere errori-->
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-3">Name</th>
                                    <th class="col-md-6">Description</th>
                                    <th class="col-md-1"></th>
                                    <th class="col-md-1"></th>
                                    <th class="col-md-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($exerciseList as $exercise) {
                                    echo '<tr>';
                                    echo '<td>' . $exercise->getName() . '</td>';
                                    echo '<td>' . $exercise->getDescription() . '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-info btn-block" href="showExercise.php?id=' . $exercise->getId() . '"><span class="glyphicon glyphicon-eye-open"></span> Show</a>';
                                    echo '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-primary btn-block" href="editExercise.php?id=' . $exercise->getId() . '"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
                                    echo '</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-danger btn-block" href="deleteExercise.php?id=' . $exercise->getId() . '"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>