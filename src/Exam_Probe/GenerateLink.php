<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class GenerateLink extends Page
{
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
        return $data;
    }

    protected function generateView():void
    {
        $this->generatePageHeader('GenerateLink');
        echo <<<EOT
        <body>
        <nav>
            <a href="">Home</a>
            <a href="">Products</a>
            <a href="">Company</a>
            <a href="">Blog</a>
</nav>

        <h1>Link Shortner!</h1>
        <form action="GenerateLink.php" method="post" accept-charset="UTF-8" id="form-id">
            <input class="top" type="text" name="URL" oninput="getHash(this.value)" />
            <input class="btn" type="submit" value="Send"/> <br>
            <p>Send a URL and we shorten it for you!</p>
            <p>Hash
            <input type="text" name="hash" value="" id="hash" readonly />          
            </p>  
</form>
</body>
EOT;
        $this->generatePageFooter();
    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();
        if(isset($_POST["URL"]) && isset($_POST['hash'])){
            $url = $_POST["URL"];
            $hash = $_POST['hash'];
            $url = $this->_database->real_escape_string($url);
            $hash = $this->_database->real_escape_string($hash);

            if($url === "") return;

            $checkQuery = "select * from hash2URL where url = '$url' and hash = '$hash'";
            $checkRecord = $this->_database->query($checkQuery);
            if(!$checkRecord) {
                throw new Exception("Query failed: " . $this->_database->error);
            }

            $count = 0;
            while ($record = $checkRecord->fetch_assoc()){
                $count++;
            }
            $checkRecord->free();

            if($count != 0){
                return;
            }
            else {
                $date = date('d-m-y h:i:s');

                $query = "insert into hash2URL values (NULL, '$date', '$url', '$hash')";

                $recordSet = $this->_database->query($query);
                if(!$recordSet){
                    throw new Exception("Query failed: " . $this->_database->error);
                }
            }
        }
    }

    public static function main():void
    {
        try {
            $page = new GenerateLink();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

GenerateLink::main();
