<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();

function __autoload($className) {
    include_once('model/' . $className . '.php');
}

$dl = new DataLayer();

if (isset($_GET['id'])) {
    $exercise = $dl->findCompleteExerciseById($_GET['id']);
    $exerciseTools = $dl->findToolByExerciseId($_GET['id']);
    $exercisePhoto = $dl->findPhotoByExerciseId($_GET['id']);
}
?>
<html>
    <?php
    echo html_head("Exercise :: Show Exercise");
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
                <li><a class="active">Show Exercise</a></li>
            </ul>
        </div>
        <!-- Page Initial Name -->
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    echo "<h1>";
                    echo "" . $exercise->getName() . "<br><br>";
                    echo "</h1>";
                    ?>
                </div>
            </div>
        </div>
        <!-- Exercise Details -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default ">
                        <!-- Default panel contents -->
                        <div class="panel-heading text-center panel-relative"><h2 class="panel-title"><strong>Exercise Details</strong></h2></div>
                        <!-- Table -->
                        <div class="col-md-12 col-xs-12">
                            <div  class="table-responsive">
                                <table class="table table-responsive text-center">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1 text-center">Reps</th>
                                            <th class="col-md-1 text-center">Sets</th>
                                            <th class="col-md-2 text-center">Rest</th>                                       
                                            <th class="col-md-1 text-center">Overweight</th>
                                            <th class="col-md-1 text-center">Unit</th>
                                            <th class="col-md-3 text-center">Tags</th>
                                            <th class="col-md-3 text-center">Tools</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        echo '<tr class="success">';
                                        echo '<td>' . $exercise->getRepsMin() . ' - ' . $exercise->getRepsMax() . '</td>';
                                        echo '<td>' . $exercise->getSetMin() . ' - ' . $exercise->getSetMax() . '</td>';
                                        echo '<td>' . $exercise->getRestMin() . ' - ' . $exercise->getRestMax() . '</td>';
                                        echo '<td>' . $exercise->getOverweightMin() . ' - ' . $exercise->getOverweightMax() . '</td>';
                                        echo '<td>' . $exercise->getOverweightUnit() . '</td>';
                                        echo '<td> TODO TAGS </td>';
                                        $result = "";
                                        foreach ($exerciseTools as $tool) {
                                            $result .= $tool->getName();
                                            $result .= ' ';
                                        }
                                        echo '<td>' . $result . '</td>';
                                        echo '</tr>';
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div> 
        <div class="container">
            <div class="row">
                <!-- Description and important Notes -->
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class='panel-heading text-center panel-relative'>
                            <h2 class="panel-title"><strong>Description and Important Notes</strong</h2>
                        </div>
                        <div class='panel-body'>
                            <p><h3><?php echo $exercise->getDescription(); ?><br></h3></p>
                            <div class="notice notice-warning">
                                <h4><strong>Important Notes</strong></h4>
                                <p>
                                <h4><?php echo $exercise->getImportantNotes(); ?></h4>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide show delle immagino con i botoni -->
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class='panel-heading text-center panel-relative'>
                            <h2 class="panel-title"><strong>Photo Description</strong</h2>
                        </div>
                        <div class='panel-body'>
                            <?php
                            foreach ($exercisePhoto as $ph) {
                                echo '<img src="' . $ph->getPath() . '" class="img-thumbnail img-responsive">';
                                echo '<figcaption class="figure-caption text-center ">' . $ph->getDescription() . '</figcaption>';
                                echo '<br>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-sm-4 -->
        </div>
    </body>
</html>
