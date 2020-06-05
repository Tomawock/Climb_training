<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();

if (isset($_GET['id'])) {
    $tp = $dl->findCompleteTrainingProgramById($_GET['id']);
    $exerciseList = $dl->getExercisesByTrainingprogram($_GET['id']);
}
?>
<html>
    <?php
    echo html_head("Training Program :: Show");
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
                <li><a class="active">Show Training Program </a></li>
            </ul>
        </div>
        <!-- Page Initial Name -->
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    echo "<h1>";
                    echo "" . $tp->getTitle() . "<br><br>";
                    echo "</h1>";
                    ?>
                </div>
            </div>
        </div>
        <!-- General Information -->
        <div class="container text-center">
            <div class="row">
                <div class="col-md-offset-4 col-md-4"> 
                    <?php
                    echo "<h3><stong>";
                    echo '<span class="glyphicon glyphicon-time"></span> ' . $tp->getTimeMin() . " - " . $tp->getTimeMax();
                    echo "</stong></h3>";
                    ?>
                </div>
                <div class="col-md-2"> 
                    <h3>
                        <label for="downloadPdfTrainingProgram" class="btn btn-success">
                            <span class="glyphicon glyphicon-download-alt"></span> Dowload PDF
                        </label>
                        <input id="downloadPdfTrainingProgram" type="submit" value='downloadPDF' class="hidden"/> 
                    </h3>
                </div>
                <div class="col-md-2"> 
                    <h3>
                        <label for="downloadJsonTrainingProgram" class="btn btn-success">
                            <span class="glyphicon glyphicon-download-alt"></span> Dowload JSON
                        </label>
                        <input id="downloadJsonTrainingProgram" type="submit" value='downloadJson' class="hidden"/> 
                    </h3>
                </div>
            </div>
        </div>
        <!-- Training Program Details  -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default ">
                        <!-- Default panel contents -->

                        <div class="panel-body text-center panel-relative">
                            <?php
                            echo "<h4>";
                            echo $tp->getDescription();
                            echo "</h4>";
                            ?>
                        </div>
                        <!-- Table -->
                        <div class="col-md-12">
                            <table class="table table-responsive table-hover table-condensed text-center">
                                <thead>
                                    <tr>
                                        <th class="col-md-2 text-center">Name</th>
                                        <th class="col-md-1 text-center">Reps</th>
                                        <th class="col-md-1 text-center">Sets</th>
                                        <th class="col-md-2 text-center">Rest</th>
                                        <th class="col-md-2 text-center">Overweight</th>
                                        <th class="col-md-2 text-center">Tags</th>
                                        <th class="col-md-2 text-center">Tools</th>         
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
                                        echo '</tr>';
                                    }
                                    ?>  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>