<?php

class DataLayer {

    public function db_connect() {
        $USERNAME = "climber";
        $PASSWORD = "climber";
        $HOST = "localhost";
        $DB_NAME = "Climb_training";

        $connection = mysqli_connect($HOST, $USERNAME, $PASSWORD, $DB_NAME)
                or die('Errore nella connessione al database: ' . mysqli_error());
        return $connection;
    }
    
    public function validUser($username, $password) {
        $connection = $this->db_connect();
        $sql = "SELECT password FROM user WHERE username = '" . $username . "'";

        $risposta = mysqli_query($connection, $sql) or
                die("Errore nella query: " . $sql . "\n" . mysqli_error());

        if (mysqli_affected_rows($connection) == 0)
            return FALSE;
        $riga = mysqli_fetch_array($risposta);
        mysqli_close($connection);

        return (md5($password) == $riga['password']);
    }

    public function addUser($name, $surname, $username, $password, $email) {
        $connection = $this->db_connect();
        $sql = "INSERT INTO user (name,surname,username,password,email) VALUES ('" . $name . "','"
                . $surname . "','" . $username . "','" . md5($password) . "','" . $email . "')";
        mysqli_query($connection, $sql) or
                die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }

    public function getUserID($username) {
        $connection = $this->db_connect();
        $sql = "SELECT id FROM user WHERE username = '" . $username . "'";

        $risposta = mysqli_query($connection, $sql) or
                die("Errore nella query: " . $sql . "\n" . mysqli_error());
        $riga = mysqli_fetch_array($risposta);
        mysqli_close($connection);

        return $riga['id'];
    }
    
    public function getUserbyUsername($username) {
        $connection = $this->db_connect();
        $sql = "SELECT * FROM user WHERE username = '" . $username . "'";

        $risposta = mysqli_query($connection, $sql) or
                die("Errore nella query: " . $sql . "\n" . mysqli_error());
        $riga = mysqli_fetch_array($risposta);
        mysqli_close($connection);

        return new User($riga['id'], $riga['name'], $riga['surname'], $riga['username'], $riga['email']);
    }

    public function searchExerciseByName($name){
        $connection = $this->db_connect();

        $sql = "SELECT * FROM exercise WHERE LOWER(`name`) LIKE LOWER('%".$name."%') ORDER BY name";
        
        $risposta = mysqli_query($connection, $sql) or
                die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);

        $exerciseList = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $exerciseList[] = new Exercise($riga['id'], $riga['name'], $riga['description']);
        }
        
        $all=$this->listExercisesSimple(); 
        //rimuovo le copie nella query generale
        foreach ($exerciseList as $searchedElem){
            foreach ($all as $index => $generalElem){
                if($searchedElem->getId()== $generalElem->getId()){
                    unset($all[$index]);
                }
            }
        }
        
        $result = array_merge($exerciseList,$all);
        
        return $result;
    }
    
    public function listExercisesSimple() {
        $connection = $this->db_connect();

        $sql = "SELECT * FROM exercise ORDER BY name";

        $risposta = mysqli_query($connection, $sql) or
                die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);

        $exerciseList = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $exerciseList[] = new Exercise($riga['id'], $riga['name'], $riga['description']);
        }
        return $exerciseList;
    }
    
    public function listExercisesComplete() {
        $connection = $this->db_connect();

        $sql = "SELECT * FROM exercise ORDER BY name";

        $risposta = mysqli_query($connection, $sql) or
                die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);

        $exerciseList = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $exerciseList[] = Exercise::completeParameters($riga['id'], $riga['name'], $riga['description'], $riga['importantNotes'],
                        $riga['repsMin'], $riga['repsMax'], $riga['setMin'], $riga['setMax'],
                        $riga['restMin'], $riga['restMax'], $riga['overweightMin'],
                        $riga['overweightMax'], $riga['overweightUnit']);
        }
        return $exerciseList;
    }

    public function findCompleteExerciseById($id) {
        $connection = $this->db_connect();
        $sql = "SELECT * FROM exercise where id='" . $id . "'";
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        mysqli_close($connection);

        $riga = mysqli_fetch_array($risposta);

        return Exercise::completeParameters($riga['id'], $riga['name'], $riga['description'], $riga['importantNotes'],
                        $riga['repsMin'], $riga['repsMax'], $riga['setMin'], $riga['setMax'],
                        $riga['restMin'], $riga['restMax'], $riga['overweightMin'],
                        $riga['overweightMax'], $riga['overweightUnit']);
    }

    public function findToolByExerciseId($id) {
        $connection = $this->db_connect();
        $sql = "SELECT * FROM exercise_to_tools where id_exercise='" . $id . "'";
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        mysqli_close($connection);     

        $exerciseTools = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $exerciseTools[] = $this->getToolById($riga['id_tool']);
        }
        
        return $exerciseTools;
    }

    public function getToolById($id) {
        $connection = $this->db_connect();
        $sql = "SELECT * FROM tecnical_tools WHERE id='".$id."'";
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        mysqli_close($connection);

        $riga = mysqli_fetch_array($risposta);
        
        return new Tool($riga['id'], $riga['name']);
    }

    public function getAllTools() {
        $connection = $this->db_connect();
        $sql = "SELECT * FROM tecnical_tools";
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        mysqli_close($connection);

        $tools = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $tools[] = new Tool($riga['id'], $riga['name']);
        }
        return $tools;
    }
    
     public function editExercise($id, $name, $description,$importantNotes,$repsMin,$repsMax,$setMin,$setMax,$restMin,$restMax, $overweightMin,$overweightMax,$overweightUnit) {
        $connection = $this->db_connect();
        $sql = "UPDATE `exercise` SET `name` = '".$name."', "
                . "`description` = '".$description."', "
                . "`importantNotes` = '".$importantNotes."', "
                . "`repsMin` = '".$repsMin."', "
                . "`repsMax` = '".$repsMax."', "
                . "`setMin` = '".$setMin."', "
                . "`setMax` = '".$setMax."', "
                . "`restMin` = '".$restMin."', "
                . "`restMax` = '".$restMax."', "
                . "`overweightMin` = '".$overweightMin."', "
                . "`overweightMax` = '".$overweightMax."', "
                . "`overweightUnit` = '".$overweightUnit."' "
                . "WHERE `exercise`.`id` = '".$id."'";
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function createExercise($name, $description,$importantNotes,$repsMin,$repsMax,$setMin,$setMax,$restMin,$restMax, $overweightMin,$overweightMax,$overweightUnit) {
        $connection = $this->db_connect();
        $sql = "INSERT INTO `exercise` (`id`, `name`, `description`, `importantNotes`, `repsMin`, `repsMax`, `setMin`, `setMax`, `restMin`, `restMax`, `overweightMin`, `overweightMax`, `overweightUnit`) VALUES (NULL,'"
                .$name."', '"
                .$description."', '"
                .$importantNotes."', '"
                .$repsMin."','"
                .$repsMax."','"
                .$setMin."','"
                .$setMax."','"
                .$restMin."','"
                .$restMax."','"
                .$overweightMin."','"
                .$overweightMax."','"
                .$overweightUnit."')";
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function deleteExercise($id){
        $connection = $this->db_connect();
        $sql = "DELETE FROM `exercise` WHERE `id`='".$id."'";
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    public function getLastIdExercise(){
        $connection = $this->db_connect();
        $sql ="SELECT id FROM `exercise` ORDER BY id DESC LIMIT 1";
                
        $risposta=mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        return mysqli_fetch_array($risposta)['id'];
    }
    
    public function isPresentExerciseToToll($idExercise,$idTool){
        $connection = $this->db_connect();
        $sql = "SELECT * FROM `exercise_to_tools` WHERE `id_exercise`='".$idExercise."' AND `id_tool`='".$idTool."'";
        
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        $res=0;
        while($riga= mysqli_fetch_array($risposta)){
            $res++;
        }
        mysqli_close($connection);

        if($res>0)
            return true;
        else
            return false;
        
    }
    
    public function createExerciseToToll($idExercise,$idTool){
        $connection = $this->db_connect();
        $sql = "INSERT INTO `exercise_to_tools` (`id`, `id_exercise`, `id_tool`) VALUES (NULL, '".$idExercise."', '".$idTool."')";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function deleteExerciseToToll($idExercise,$idTool){
        $connection = $this->db_connect();
        $sql = "DELETE FROM `exercise_to_tools` WHERE `id_exercise`='".$idExercise."' AND `id_tool`='".$idTool."'";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function deletePhoto($idPhoto){
        exec("rm ".$this->getPhotoById($idPhoto)->getPath());//delete image from server 
        
        $connection = $this->db_connect();
        $sql = "DELETE FROM `photo` WHERE `id`='".$idPhoto."'";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        
    }
    
    public function deleteExerciseToPhoto($idExercise,$idPhoto){
        $connection = $this->db_connect();
        
        $sql = "DELETE FROM `exercise_to_photo` WHERE `id_exercise`='".$idExercise."' AND `id_photo`='".$idPhoto."'";
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function deleteExerciseToPhotoRecursive($idExercise){
        $connection = $this->db_connect();
        $photostodelete= $this->findPhotoByExerciseId($idExercise);//prima cerco gli id e dopo cancello le foto associate 
        
        $sql = "DELETE FROM `exercise_to_photo` WHERE `id_exercise`='".$idExercise."'";
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        foreach ($photostodelete as $photo){
            $this->deletePhoto($photo->getId());
        }
        mysqli_close($connection);
    }
    
    public function createPhoto($path,$description){
        $connection = $this->db_connect();
        $sql = "INSERT INTO `photo` (`id`, `path`, `description`) VALUES (NULL, '".$path."', '".$description."')";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function getLastIdPhoto(){
        $connection = $this->db_connect();
        $sql ="SELECT id FROM `photo` ORDER BY id DESC LIMIT 1";
                
        $risposta=mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        return mysqli_fetch_array($risposta)['id'];
        
    }
    public function createExerciseToPhoto($idExercise,$idPhoto){
        $connection = $this->db_connect();
        $sql = "INSERT INTO `exercise_to_photo` (`id`, `id_exercise`, `id_photo`) VALUES (NULL, '".$idExercise."', '".$idPhoto."')";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    public function findPhotoByExerciseId($id){
        $connection = $this->db_connect();
        $sql = "SELECT * FROM exercise_to_photo WHERE id_exercise='" . $id . "'";
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        mysqli_close($connection);     

        $exercisePhoto = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $exercisePhoto[] = $this->getPhotoById($riga['id_photo']);
        }
        
        return $exercisePhoto;
    }
    
    public function getPhotoById($id){
        $connection = $this->db_connect();
        $sql = "SELECT * FROM photo WHERE id='".$id."'";
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        mysqli_close($connection);

        $riga = mysqli_fetch_array($risposta);
        
        return new Photo($riga['id'], $riga['path'],$riga['description']);
        
    }
    
    public function listTrainingProgramSimple() {
        $connection = $this->db_connect();

        $sql = "SELECT * FROM trainingprogram ORDER BY title";

        $risposta = mysqli_query($connection, $sql) or
                die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);

        $tpList = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $tpList[] = new TrainingProgram($riga['id'], $riga['title'], $riga['description']);
        }
        return $tpList;
    }
    
    public function addTrainingprogramToUser($trainingprogramID, $username){
        $userId=$this->getUserID($username);
        
        $connection = $this->db_connect();
        $sql = "INSERT INTO `user_trainingprogram` (`id`, `trainingprogram_id`, `user_id`) VALUES (NULL, '".$trainingprogramID."', '".$userId."')";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function getMyTrainingprogramsId($username){
        $userId=$this->getUserID($username);
        
        $connection = $this->db_connect();
        $sql = "SELECT `trainingprogram_id` FROM `user_trainingprogram` WHERE `user_id`=".$userId;
        
         $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        
        $myTainningprograms = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $myTainningprograms[] = $riga['trainingprogram_id'];
        }
        return $myTainningprograms;
    }
    
    public function getMyTrainingprogramsComplete($username){
        $userId=$this->getUserID($username);
        
        $connection = $this->db_connect();
        $sql = "SELECT `trainingprogram_id` FROM `user_trainingprogram` WHERE `user_id`=".$userId;
        
         $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        
        $myTainningprograms = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $myTainningprograms[] = $this->findCompleteTrainingProgramById($riga['trainingprogram_id']);
        }
        return $myTainningprograms;
    }
    
    public function findCompleteTrainingProgramById($tpId){
        
        $connection = $this->db_connect();
        $sql = "SELECT * FROM `trainingprogram` WHERE id='".$tpId."'";
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        mysqli_close($connection);

        $riga = mysqli_fetch_array($risposta);
        $exerciseList=$this->getExercisesByTrainingprogram($tpId);//list of exercises
        return TrainingProgram::completeParameters($riga['id'], $riga['title'],$riga['description'],$riga['timeMin'],$riga['timeMax'],$exerciseList);
    }
    
    public function getExercisesByTrainingprogram($tpId){
        
        $connection = $this->db_connect();
        $sql = "SELECT `id_exercise` FROM `trainingprogram_to_exercise` WHERE `id_trainingProgram`=".$tpId;
        
         $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        
        $exercises = array();
        while ($riga = mysqli_fetch_array($risposta)) {
            $exercises[] = $this->findCompleteExerciseById($riga['id_exercise']);
        }
        return $exercises;
    }
    
     public function editTrainingProgram($id, $title, $description,$timeMin,$timeMax){
        $connection = $this->db_connect();
        $sql = "UPDATE `trainingprogram` SET `title` = '".$title."', "
                . "`description` = '".$description."', "
                . "`timeMin` = '".$timeMin."', "
                . "`timeMax` = '".$timeMax."'"
                . " WHERE `id` = '".$id."'";
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        
    }
    
     public function createTrainingProgram($title, $description,$timeMin,$timeMax){
        $connection = $this->db_connect();
        $sql = "INSERT INTO `trainingprogram`(`id`, `title`, `description`, `timeMin`, `timeMax`) VALUES (NULL, "
                . "'".$title."', "
                . "'".$description."', "
                . "'".$timeMin."', "
                . "'".$timeMax."')";
        
        echo $sql;
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        
    }
    
    public function addExerciseToTrainingprogram($tpid,$exercises){
        $sql="";
        foreach ($exercises as $ex){
            $sql.="INSERT INTO `trainingprogram_to_exercise`(`id`, `id_exercise`, `id_trainingProgram`) VALUES"
                    . " (NULL ,".$ex->getId().",".$tpid.");";
        }
        echo $sql;
        $connection = $this->db_connect();
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function isPresentExerciseToTrainingprogram($idExercise,$idTp) {
        $connection = $this->db_connect();
        $sql = "SELECT * FROM `trainingprogram_to_exercise` WHERE `id_exercise`='".$idExercise."' AND `id_trainingProgram`='".$idTp."'";
        
        $risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        $res=0;
        while($riga= mysqli_fetch_array($risposta)){
            $res++;
        }
        mysqli_close($connection);

        if($res>0)
            return true;
        else
            return false;
        
    }
    
    public function createExerciseToTrainingprogram($idExercise,$idTp){
        $connection = $this->db_connect();
        $sql = "INSERT INTO `trainingprogram_to_exercise` (`id`, `id_exercise`, `id_trainingProgram`) VALUES (NULL, '".$idExercise."', '".$idTp."')";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function deleteExerciseToTrainingprogram($idExercise,$idTp) {
         $connection = $this->db_connect();
        $sql = "DELETE FROM `trainingprogram_to_exercise` WHERE `id_exercise`='".$idExercise."' AND `id_trainingProgram`='".$idTp."'";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function getLastIdTrainingprogram(){
        $connection = $this->db_connect();
        $sql ="SELECT id FROM `trainingprogram` ORDER BY id DESC LIMIT 1";
                
        $risposta=mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
        return mysqli_fetch_array($risposta)['id'];
        
    }
    
    public function deleteTrainingProgramToAllUser($tpId){
        $connection = $this->db_connect();
        $sql = "DELETE FROM `user_trainingprogram` WHERE `trainingprogram_id`=".$tpId;
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function deleteTrainingProgram($tpId){
        $connection = $this->db_connect();
        $sql = "DELETE FROM `trainingprogram` WHERE `id`=".$tpId;
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function deleteTrainingProgramToUser($userId,$tpId){
        $connection = $this->db_connect();
        $sql = "DELETE FROM `user_trainingprogram` WHERE `trainingprogram_id`=".$tpId." AND `user_id`=".$userId;
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
    
    public function createUserTrainingProgramExecution($idEx,$idTp,$idUsr,$reps,$sets,$date,$note){
        $connection = $this->db_connect();
        $sql = "INSERT INTO `user_trainingprogram_execution`(`id`, `id_exercise`, `id_trainingProgram`, `id_user`, `reps`, `sets`, `date`, `note`) VALUES "
                . "(NULL, '".$idEx."','".$idTp."','".$idUsr."','".$reps."','".$sets."','".$date."','".$note."')";
        
        mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        mysqli_close($connection);
    }
}
?>

