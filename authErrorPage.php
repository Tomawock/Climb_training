<?PHP
require_once('utils/XHTML_functions.php');
?>
<html>
    <?php
    echo html_head("Climb Training");
    ?>

    <body>

        <div class="container text-center">
            <div class="row" style="margin-top: 4em;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-danger">
                        <div class='panel-heading'>
                            Authentication Error
                        </div>
                        <div class='panel-body'>
                            <p>Wrong credentials while accessing this page</p>
                            <p><a class="btn btn-default" href="index.php"><span class='glyphicon glyphicon-log-out'></span> Back to home</a></p>
                            <p><a href="#" class="forgot-password">Forgot Password?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>