<?php declare(strict_types=1);

class Order_Product{
    public $name;
    public $orderID;    // ordered_article_id
    public $orderNr;    // ordering_id
    public $picture;
    public $price;
    public $status;

    function __construct($name, $orderID, $orderNr, $picture, $price, $status){
        $this->name = $name;
        $this->orderID = $orderID;
        $this->orderNr = $orderNr;
        $this->picture = $picture;
        $this->price = $price;
        $this->status = $status;
    }
}
