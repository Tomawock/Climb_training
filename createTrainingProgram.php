<?PHP
require_once('utils/XHTML_functions.php');

userLoggedControl();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Training Program :: Create </title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

        <!-- Fogli di stile -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <!-- Tags Style-->
        <link rel="stylesheet" href="../css/bootstrap-tagsinput.css">

        <!-- jQuery e plugin JavaScript  -->
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Tags scripts-->
        <script src="js/tags/bootstrap-tagsinput.js"></script>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span> 
                </button>

                <!-- da qua inizia la ver navbarprima serviva solo nel cao in cui lo schermo è picolo -->
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Training<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="account.php">Account</a></li>
                                <li><a href="trainingProgramList.php">Personal Training Program</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Training<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="exercisesList.php">Exercise List</a></li>
                                <li><a href="trainingProgramList.php">Training Program List</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="loginRegister.php">Log-in / Register</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Breadcrumb -->
        <div class="container">
            <ul class="breadcrumb pull-right">
                <li><a href="index.php">Home</a></li>
                <li><a href="trainingProgramList.php">Training Program List</a></li>
                <li><a class="active">New Training Program</a></li>
            </ul>
        </div>
        <!-- Page Initial Name -->
        <div class="container">
            <header class="header-sezione">
                <h1>
                    New Training Program
                </h1>
            </header>
        </div>

        <div class="container">
            <div class="row">
                <div class='col-md-12'>
                    <form class="form-horizontal" name="trainingProgram" method="get" action="#">
                        <!-- Title of the Training Program-->
                        <div class="form-group">
                            <label for="trainingProgramTitle" class="col-md-2">Title</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="trainingProgramTitle" name="trainingProgramTitle" placeholder="Training Program Title">
                            </div>
                        </div>
                        <!-- Description-->
                        <div class="form-group">
                            <label for="trainingProgramDescription" class="col-md-2">Description</label>
                            <div class="col-md-10">
                                <textarea class="form-control" rows="4" id="trainingProgramDescription" name="trainingProgramDescription" placeholder="Complete Training Program Description"></textarea>
                            </div>
                        </div>
                        <!-- Time Averange fo the completment of the Training program -->
                        <div class="form-group">
                            <label for="trainingProgramTime" class="col-md-2">Time</label>
                            <label for="trainingProgramTimeMin" class="col-md-1">Min</label>

                            <span class="glyphicon glyphicon-time"></span>

                            <div class="col-md-1">
                                <select class="form-control" id="trainingProgramTimeMin">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>

                            <label for="trainingProgramTimeMax" class="col-md-1">Max</label>
                            <div class="col-md-1">
                                <select class="form-control" id="trainingProgramTimeMax">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>
                        <!-- Standrd Training or not-->
                        <div class="form-group">
                            <label for="trainingProgramStandard" class="col-md-2">Standard</label>
                            <div class="checkbox col-md-1">
                                <input class="form-control" type="checkbox" id="trainingProgramStandard">
                            </div>
                        </div>
                        <!-- lista di tutti gli esercizi disponibili con ceckbox associate-->                       
                    </form>

                </div>
            </div>
        </div>
        <!--tabella con ricerca-->
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xs-12">
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
                                <a class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Submit</a>
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
                                        <th class="col-md-1 text-center">Rest</th>
                                        <th class="col-md-1 text-center">Overweight</th>
                                        <th class="col-md-2 text-center">Tags</th>
                                        <th class="col-md-2 text-center">Tools</th>
                                        <th class="col-md-1 text-center">Selected</th>
                                        <th class="col-md-1 text-center">Position</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Dips</td>
                                        <td>15 - 20</td>
                                        <td>2 - 3</td>
                                        <td>2 - 3 min.</td>
                                        <td>20 - 30 Kg.</td>
                                        <td>Finger Strength, Endurance</td>
                                        <td>BeastMaker 2000, BeastMaker 1000, IseClimbingFingerBoard</td>
                                        <td>
                                            <input type="checkbox" id="exerciseId">
                                        </td>
                                        <td>
                                            <select class="form-control" id="exerciseOrder">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dips</td>
                                        <td>15 - 20</td>
                                        <td>2 - 3</td>
                                        <td>2 - 3 min.</td>
                                        <td>20 - 30 Kg.</td>
                                        <td>Finger Strength, Endurance</td>
                                        <td>BeastMaker 2000, BeastMaker 1000, IseClimbingFingerBoard</td>
                                        <td>
                                            <input type="checkbox" id="exerciseId">
                                        </td>
                                        <td>
                                            <select class="form-control" id="exerciseOrder">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dips</td>
                                        <td>15 - 20</td>
                                        <td>2 - 3</td>
                                        <td>2 - 3 min.</td>
                                        <td>20 - 30 Kg.</td>
                                        <td>Finger Strength, Endurance</td>
                                        <td>BeastMaker 2000, BeastMaker 1000, IseClimbingFingerBoard</td>
                                        <td>
                                            <input type="checkbox" id="exerciseId">
                                        </td>
                                        <td>
                                            <select class="form-control" id="exerciseOrder">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dips</td>
                                        <td>15 - 20</td>
                                        <td>2 - 3</td>
                                        <td>2 - 3 min.</td>
                                        <td>20 - 30 Kg.</td>
                                        <td>Finger Strength, Endurance</td>
                                        <td>BeastMaker 2000, BeastMaker 1000, IseClimbingFingerBoard</td>
                                        <td>
                                            <input type="checkbox" id="exerciseId">
                                        </td>
                                        <td>
                                            <select class="form-control" id="exerciseOrder">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dips</td>
                                        <td>15 - 20</td>
                                        <td>2 - 3</td>
                                        <td>2 - 3 min.</td>
                                        <td>20 - 30 Kg.</td>
                                        <td>Finger Strength, Endurance</td>
                                        <td>BeastMaker 2000, BeastMaker 1000, IseClimbingFingerBoard</td>
                                        <td>
                                            <input type="checkbox" id="exerciseId">
                                        </td>
                                        <td>
                                            <select class="form-control" id="exerciseOrder">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Buttons -->
            <div class="row">
                <!-- Buttons confirm-->
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="saveTrainingProgram" class="btn btn-primary btn-large btn-block"><span class="glyphicon glyphicon-floppy-save"></span> Save</label>
                        <input id="saveTrainingProgram" type="submit" value='Save' class="hidden"/>                         
                    </div>
                </div>
                <!-- Buttons cancel-->
                <div class="form-group">
                    <div class="col-md-12">
                        <a href="trainingProgramList.php" class="btn btn-danger btn-large btn-block"><span class="glyphicon glyphicon-log-out"></span> Cancel</a>                         
                    </div>
                </div>   
            </div>
        </div>
    </div>
</body>
</html>
