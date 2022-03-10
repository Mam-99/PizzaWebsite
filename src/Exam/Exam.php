<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Exam extends Page
{
    private $erfolgreich = false;
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

        $query = "select * from regler where id = 1 or id = 2 order by id";
        $recordSet = $this->_database->query($query);
        if(!$recordSet){
            throw new Exception("Query failed: " . $this->_database->error);
        }

        while(($record = $recordSet->fetch_assoc())){
            array_push($data, $record);
        }

        $recordSet->free();

        return $data;
    }

    protected function generateView():void // Aufgabe 1a
    {
        $this->generatePageHeader("Feedback zur Vorlesung");
        $data = $this->getViewData();
        // 1a
        echo<<<EOT
        <body>
            <h1>Feedback zur Vorlesung</h1>
EOT;
        if($this->erfolgreich){ // 1f
            echo<<<EOT
            <div class="status" style="display : none">Die Daten wurden erfolgreich gespeichert</div>
EOT;
        }
        echo<<<EOT
            <form action="Exam.php" method="post" charset-accept="UTF-8">
EOT;
        $this->createRangeInput($data);

        // 1d
        echo<<<EOT
                <input type="text" name="matrikel" value="" placeholder="Matrikelnummer" required /> <br>   
                <input type="submit" name="submit" value="Abschicken" />
            </form>
        </body>
EOT;

        $this->generatePageFooter();
    }

    private function createRangeInput($data){   // 1b
        echo<<<EOT
        <label for="id2">Arbeitsatmosphäre (Durchschnitt <span id="durchschitt-id1"><span>)</label> <br>
        <input type="range" name="id2" id="id2" step="1" min="{$data[1]['min_value']}" max="{$data[1]['max_value']}" /> 
        <span id="input-id2"> /{$data[1]['max_value']}</span> <br>      

        <label for="id1">Arbeitsatmosphäre (Durchschnitt <span id="durchschitt-id2"><span>)</label> <br>
        <input type="range" name="id1" id="id1" step="1" min="{$data[0]['min_value']}" max="{$data[0]['max_value']}" /> 
        <span id="input-id1"> /{$data[0]['max_value']}</span> <br>
EOT;
    }

    protected function processReceivedData():void // 1e
    {
        parent::processReceivedData();
        if(isset($_POST['submit']) and isset($_POST['matrikel'])){
            $matrikel = $this->_database->real_escape_string($_POST['matrikel']);
            $valueRegler1 = $_POST['id1'];
            $valueRegler2 = $_POST['id2'];

            $query1 = "insert into bewertung values (NULL, $matrikel, 1, $valueRegler1)";
            $query2 = "insert into bewertung values (NULL, $matrikel, 2, $valueRegler2)";

            $ok1 = $this->_database->query($query1);
            if(!$ok1){
                throw new Exception("Query failed: " . $this->_database->error);
            }

            $ok2 = $this->_database->query($query2);
            if(!$ok2){
                throw new Exception("Query failed: " . $this->_database->error);
            }

            $this->erfolgreich = true;
        }
    }

    public static function main():void
    {
        try {
            $page = new Exam();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}


Exam::main();

