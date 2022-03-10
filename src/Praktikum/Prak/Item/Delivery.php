<?php declare(strict_types=1);

class Order_Delivery{
    public $name;
    public $orderID;    // ordered_article_id
    public $orderNr;    // ordering_id
    public $status;
    public $address;

    function __construct($name, $orderID, $orderNr, $status, $address){
        $this->name = $name;
        $this->orderID = $orderID;
        $this->orderNr = $orderNr;
        $this->status = $status;
        $this->address = $address;
    }
}
