<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class Forward extends Page
{
    private String $hash = "";
    private String $links = "";

    protected function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData():array
    {
        $data = array();

        if(isset($_GET['Hash'])){
            $this->hash = $_GET['Hash'];
        }

        $hashWert = $this->_database->real_escape_string($this->hash);
        $query = "select url from hash2URL where hash = '$hashWert'";
        $recordSet = $this->_database->query($query);
        if(!$recordSet) {
            throw new Exception("Query failed: " . $this->_database->error);
        }

        $data = $recordSet->fetch_assoc();
        $recordSet->free();

        return $data;
    }

    protected function generateView():void
    {
        $this->generatePageHeader('Forward');

        $this->generatePageFooter();
    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();

        $data = $this->getViewData();

        $this->links = $data['url'];

        header("Location: " . $this->links);
    }

    public static function main():void
    {
        try {
            $page = new Forward();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Forward::main();
