<?php
/**
 * Description of trainingProgram
 *
 * @author tomawock
 */
class TrainingProgram {
    private $id;
    private $title; 
    private $description;
    
    private $timeMin;
    private $timeMax;
    
    private $exercies;

    public function __construct($id, $title, $description) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    public static function completeParameters($id, $title, $description,$timeMin,$timeMax,$exercies) {
        
        $instance = new self($id, $title, $description);
        
        $instance->setTimeMin($timeMin);
        $instance->setTimeMax($timeMax);
        $instance->setExercies($exercies);
        
        return $instance;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getTimeMin() {
        return $this->timeMin;
    }

    public function getTimeMax() {
        return $this->timeMax;
    }

    public function getExercies() {
        return $this->exercies;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setTitle($title): void {
        $this->title = $title;
    }

    public function setDescription($description): void {
        $this->description = $description;
    }

    public function setTimeMin($timeMin): void {
        $this->timeMin = $timeMin;
    }

    public function setTimeMax($timeMax): void {
        $this->timeMax = $timeMax;
    }

    public function setExercies($exercies): void {
        $this->exercies = $exercies;
    }
}
?>