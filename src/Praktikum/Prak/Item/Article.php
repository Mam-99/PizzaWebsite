<?php declare(strict_types=1);

class Article{
    public $id;
    public $name;
    public $picture;
    public $price;

    function __construct($id, $name, $picture, $price){
        $this->id = $id;
        $this->name = $name;
        $this->picture = $picture;
        $this->price = $price;
    }
}
