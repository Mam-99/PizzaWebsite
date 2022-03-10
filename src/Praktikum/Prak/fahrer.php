<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
/**
 * Class PageTemplate for the exercises of the EWA lecture
 * Demonstrates use of PHP including class and OO.
 * Implements Zend coding standards.
 * Generate documentation with Doxygen or phpdoc
 *
 * PHP Version 7.4
 *
 * @file     PageTemplate.php
 * @package  Page Templates
 * @author   Bernhard Kreling, <bernhard.kreling@h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
 * @version  3.0
 */

// to do: change name 'PageTemplate' throughout this file
require_once './Base-Project/Page.php';
require_once './Item/Delivery.php';

session_start();

/**
 * This is a template for top level classes, which represent
 * a complete web page and which are called directly by the user.
 * Usually there will only be a single instance of such a class.
 * The name of the template is supposed
 * to be replaced by the name of the specific HTML page e.g. baker.
 * The order of methods might correspond to the order of thinking
 * during implementation.
 * @author   Bernhard Kreling, <bernhard.kreling@h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
 */
class Fahrer extends Page
{
    // to do: declare reference variables for members

    // representing substructures/blocks

    /**
     * Instantiates members (to be defined above).
     * Calls the constructor of the parent i.e. page class.
     * So, the database connection is established.
     * @throws Exception
     */
    protected function __construct()
    {
        parent::__construct();
        // to do: instantiate members representing substructures/blocks
    }

    /**
     * Cleans up whatever is needed.
     * Calls the destructor of the parent i.e. page class.
     * So, the database connection is closed.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is returned in an array e.g. as associative array.
     * @return array An array containing the requested data.
     * This may be a normal array, an empty array or an associative array.
     */
    protected function getViewData():array
    {
        // to do: fetch data for this view from the database
        // to do: return array containing data
        $orders = array();

        $guest = (isset($_SESSION["guestID"]))? $_SESSION["guestID"] : -1;

        if($guest == -1) return $orders;

        $query = "select article.name, ordered_article.ordered_article_id, ordered_article.ordering_id,
                    ordered_article.status, ordering.address from article inner join ordered_article using(article_id)
                    inner join ordering using(ordering_id) where ordered_article.status > 1 
                    and ordering_id = {$guest} order by ordered_article_id";

        $records = $this->_database->query($query);
        if(!$records){
            throw new Exception("Query failed: " . $this->_database->error);
        }

        while($record = $records->fetch_assoc()){
            $order = new Order_Delivery($record["name"], $record["ordered_article_id"],
                                        $record["ordering_id"], $record["status"],
                                        $record["address"]);
            $orders[$order->orderID] = $order;
        }
        $records->free();

        return $orders;
    }

    /**
     * First the required data is fetched and then the HTML is
     * assembled for output. i.e. the header is generated, the content
     * of the page ("view") is inserted and -if available- the content of
     * all views contained is generated.
     * Finally, the footer is added.
     * @return void
     */
    protected function generateView():void
    {
        try {
            $data = $this->getViewData(); // NOSONAR ignore unused $data
            $this->generatePageHeader('Lieferung');
            // to do: output view of this page using $data

            $guest = (isset($_SESSION["guestID"])) ? $_SESSION["guestID"] : -1;

            echo <<<EOT
            <section class="backer-section">
    EOT;

            if($guest == -1) {
                echo <<<EOT
           <h4>Sie haben noch keine Bestellungen</h4>
EOT;
                return;
        }

            $guest = "";
            if(isset($_SESSION['guestName'])){
                $guest = $_SESSION['guestName'];
            }

            echo <<<EOT
            <h3>Bestellungen von #{$guest}</h3>  
    EOT;


            if(sizeof($data) == 0 || $guest == -1){
                echo "<h4>Pizza werden gerade gebackt!</h4>";
            }
            else{
                echo <<<EOT
                <form action="fahrer.php" id="form_liefer" accept-charset="UTF-8" method="post" class="form-fahrer">
        EOT;
                foreach($data as $order){
                    $address = htmlspecialchars($order->address);
                    $orderID = htmlspecialchars($order->orderID);
                    echo <<<EOT
                    <div class="pizza-fahrer">
                    <p>Bestellung #$orderID - Adresse: $address</p>
                    <table>
        EOT;
                    $this->createRadioButton($orderID, $order->status, "fertig", 2);
                    $this->createRadioButton($orderID, $order->status, "unterwegs", 3);
                    $this->createRadioButton($orderID, $order->status, "geliefert", 4);
                    echo "</table>";
                    echo "</div>";
                }
                echo "</form>";
            }

            echo "</section>";
            $this->generatePageFooter();
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    private function createRadioButton($Id, $status, $nameStatus, $value):void {
        $check = ($status == $value)? "checked" : "";
        $name = htmlspecialchars($nameStatus);
        echo <<<EOT
        <tr>
            <td><label for="status-$Id">$name</label><br></td>
            <td><input type="radio" name="statuses[{$Id}]" id="status-$Id-$value" $check value="$value" onclick="document.forms['form_liefer'].submit()"/></td>
        </tr>
        
        
    EOT;

    }

    /**
     * Processes the data that comes via GET or POST.
     * If this page is supposed to do something with submitted
     * data do it here.
     * @return void
     */
    protected function processReceivedData():void
    {
        parent::processReceivedData();
        // to do: call processReceivedData() for all members

        if(isset($_POST['statuses'])){
            $statuses = $_POST['statuses'];
            foreach($statuses as $Id => $Status){
                $id = $this->_database->real_escape_string((string)$Id);
                $status = $this->_database->real_escape_string((string)$Status);

                $query = "update ordered_article set status = $status where ordered_article_id = $id";
                $recordSet = $this->_database->query($query);
                if(!$recordSet){
                    throw new Exception("Query failed: " . $this->_database->error);
                }
            }
        }
    }

    /**
     * This main-function has the only purpose to create an instance
     * of the class and to get all the things going.
     * I.e. the operations of the class are called to produce
     * the output of the HTML-file.
     * The name "main" is no keyword for php. It is just used to
     * indicate that function as the central starting point.
     * To make it simpler this is a static function. That is you can simply
     * call it without first creating an instance of the class.
     * @return void
     */
    public static function main():void
    {
        try {
            $page = new Fahrer();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            //header("Content-type: text/plain; charset=UTF-8");
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page.
// That is input is processed and output is created.
Fahrer::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >
