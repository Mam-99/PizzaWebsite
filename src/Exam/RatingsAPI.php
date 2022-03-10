<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

//require_once './Page.php';

class RatingsAPI 
{
    const TEST_DATA = '[ 
        {"Regler-ID": "1", "Bewertungen": [5, 4, 2, 1, 7, 3, 4, 2]},
        {"Regler-ID": "2", "Bewertungen": [2, 1, 1, 4, 1, 1, 2, 2]} ]';
    
    protected function __construct()
    {
//        parent::__construct();
    }

    public function __destruct()
    {
//        parent::__destruct();
    }

    protected function getViewData():array
    {
    }

    protected function generateView():void
    {
       header("Content-Type: application/json; charset=UTF-8");
//        $data = $this->getViewData();
//        $serializedData = json_encode($data);
        echo self::TEST_DATA; 
    }

    protected function processReceivedData():void
    {
//        parent::processReceivedData();
    }

    public static function main():void
    {
        try {
            $page = new RatingsAPI();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

RatingsAPI::main();
