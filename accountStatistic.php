<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();

$user = $dl->getUserbyUsername($_SESSION['loggedName']);

$tpexecution = $dl->getUserTrainingProgramExecutionByUserId($user->getId());
?>
<html>
    <?php
    echo html_head("History and Statistics ");
    ?>
    <body>
        <?php
        echo html_navbar();
        ?>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>         
                <li><a class="active">History and Statistics</a></li>
            </ul>
        </div>
        <!-- Page Initial Name --> 
        <div class="container">
            <header class="header-sezione text-center">
                <?php
                echo "<h1>";
                echo "History and Statistics<br><br>";
                echo "</h1>";
                ?>            
            </header>
        </div>

        <div class="container">
            <div class="row">
                <?php
                $date = null;
                $tpid = null;
                foreach ($tpexecution as $ex) {
                    if ($ex['date'] != $date || $ex['tp']->getId() != $tpid) {
                        $date = $ex['date'];
                        $tpid = $ex['tp']->getId();
                        //creo una nuova table
                        $executionArray = $dl->getUserTrainingProgramExecutionByUserIdDateAndTrainingProgram($user->getId(), $date, $tpid);
                        echo '<div class="panel panel-default ">';
                        echo '<div class="panel-heading text-center panel-relative">';
                        echo '<h2 class="panel-title">';
                        echo '<strong> Training: ' . $ex['tp']->getTitle() . ' executed on Date: ' . date("d/m/Y",strtotime($ex['date'])). '</strong>';
                        echo '</h2>';
                        echo '</div>';
                        echo '<div class="panel-body">';
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-responsive table-hover text-center">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="col-md-2 text-center">Name</th>';
                        echo '<th class="col-md-2 text-center">Reps Suggested</th>';
                        echo '<th class="col-md-2 text-center">Sets Suggested</th>';
                        echo '<th class="col-md-2 text-center">Reps Executed</th>';
                        echo '<th class="col-md-2 text-center">Sets executed</th>';
                        echo '<th class="col-md-2 text-center">Notes</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach ($executionArray as $executedExercise) {
                            echo '<tr>';
                            echo '<td><div style="height:50px; overflow:hidden">' . $executedExercise['executed']->getName() . '</div></td>';
                            echo '<td><div style="height:50px; overflow:hidden">' . $executedExercise['executed']->getRepsMin() . ' - ' . $executedExercise['executed']->getRepsMax() . '</div></td>';
                            echo '<td><div style="height:50px; overflow:hidden">' . $executedExercise['executed']->getSetMin() . ' - ' . $executedExercise['executed']->getSetMax() . '</div></td>';
                            echo '<td><div style="height:50px; overflow:hidden">' . $executedExercise['reps'] . '</div></td>';
                            echo '<td><div style="height:50px; overflow:hidden">' . $executedExercise['sets'] . '</div></td>';
                            echo '<td><div style="height:50px; overflow:hidden">' . $executedExercise['note'] . '</div></td>';
                            echo '</tr>';
                        }
                        unset($executionArray);
                        $executionArray = array();
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>