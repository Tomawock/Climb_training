<?php
/**
 * Description of Photo
 *
 * @author tomawock
 */
class Photo {
    
    private $id;
    private $path;
    private $description;
    
    public function __construct($id, $path, $description) {
        $this->id = $id;
        $this->path = $path;
        $this->description = $description;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getPath() {
        return $this->path;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setPath($path): void {
        $this->path = $path;
    }

    public function setDescription($description): void {
        $this->description = $description;
    }    
}
