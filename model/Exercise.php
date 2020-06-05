<?php
/**
 * Description of exercise
 *
 * @author tomawock
 */
class Exercise {
    private $id;
    private $name; 
    private $description;
    private $importantNotes;


    private $repsMin;
    private $repsMax;
    
    private $setMin;
    private $setMax;
    
    private $restMin;
    private $restMax;
    
    private $overweightMin;
    private $overweightMax;
    private $overweightUnit;
    
    private $tags;
    private $tools;
    
    public function __construct($id, $name, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public static function completeParameters($id, $name, $description,$importantNotes,$repsMin,$repsMax,$setMin,$setMax,$restMin,$restMax, $overweightMin,$overweightMax,$overweightUnit) {
        
        $instance = new self($id, $name, $description);
        
        $instance->setImportantNotes($importantNotes);
        $instance->setRepsMin($repsMin);
        $instance->setRepsMax($repsMax);
        $instance->setSetMin($setMin);
        $instance->setSetMax($setMax);
        $instance->setRestMin($restMin);
        $instance->setRestMax($restMax);
        $instance->setOverweightMin($overweightMin);
        $instance->setOverweightMax($overweightMax);
        $instance->setOverweightUnit($overweightUnit);
        
        return $instance;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImportantNotes() {
        return $this->importantNotes;
    }

    public function getRepsMin() {
        return $this->repsMin;
    }

    public function getRepsMax() {
        return $this->repsMax;
    }

    public function getSetMin() {
        return $this->setMin;
    }

    public function getSetMax() {
        return $this->setMax;
    }

    public function getRestMin() {
        return $this->restMin;
    }

    public function getRestMax() {
        return $this->restMax;
    }

    public function getOverweightMin() {
        return $this->overweightMin;
    }

    public function getOverweightMax() {
        return $this->overweightMax;
    }

    public function getOverweightUnit() {
        return $this->overweightUnit;
    }

    public function getTags() {
        return $this->tags;
    }

    public function getTools() {
        return $this->tools;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setDescription($description): void {
        $this->description = $description;
    }

    public function setImportantNotes($importantNotes): void {
        $this->importantNotes = $importantNotes;
    }

    public function setRepsMin($repsMin): void {
        $this->repsMin = $repsMin;
    }

    public function setRepsMax($repsMax): void {
        $this->repsMax = $repsMax;
    }

    public function setSetMin($setMin): void {
        $this->setMin = $setMin;
    }

    public function setSetMax($setMax): void {
        $this->setMax = $setMax;
    }

    public function setRestMin($restMin): void {
        $this->restMin = $restMin;
    }

    public function setRestMax($restMax): void {
        $this->restMax = $restMax;
    }

    public function setOverweightMin($overweightMin): void {
        $this->overweightMin = $overweightMin;
    }

    public function setOverweightMax($overweightMax): void {
        $this->overweightMax = $overweightMax;
    }

    public function setOverweightUnit($overweightUnit): void {
        $this->overweightUnit = $overweightUnit;
    }

    public function setTags($tags): void {
        $this->tags = $tags;
    }

    public function setTools($tools): void {
        $this->tools = $tools;
    }
}
?>
