<?php
class Tool {
    
    private $id;
    private $name;
    
    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setName($name): void {
        $this->name = $name;
    }
    
    public  function isInside($array){
        
        foreach ($array as $el){
            if ($this->id==$el->id)
                return true;
        }
        return false;
    }
}
