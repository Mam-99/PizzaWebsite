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
require_once './Item/Order.php';

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
class Kunde extends Page
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
        $guest = (isset($_SESSION['guestID']))? $_SESSION['guestID'] : -1;
        if($guest == -1) return $orders;

        $query = "select article.name, article.picture, article.price, ordered_article.ordered_article_id, 
                    ordered_article.ordering_id, ordered_article.status from article join ordered_article
                    where article.article_id = ordered_article.article_id and ordered_article.ordering_id = {$guest} order by ordered_article.ordered_article_id";

        $records = $this->_database->query($query);
        if(!$records){
            throw new Exception("Query failed: " . $this->_database->error);
        }

        while($record = $records->fetch_assoc()){
            $order = new Order_Product($record["name"], $record["ordered_article_id"],
                                        $record["ordering_id"], $record["picture"],
                                        $record["price"], $record["status"]);
            $orders[$order->orderID] = $order;  // Save order_product with ordered_article_id as orderID
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
        try{
            $data = $this->getViewData(); // NOSONAR ignore unused $data
            $this->generatePageHeader('Kunde');
            // to do: output view of this page using $data
            echo <<<EOT
            <script src="Script/StatusUpdate.js"></script>
        EOT;

            if(sizeof($data) == 0){
                echo <<<EOT
            <section class="backer-section">
                <h4>Sie haben noch keine Bestellungen</h4>
            </section>
EOT;

            }
            else{
                $guest = "";
                if(isset($_SESSION['guestName'])){
                    $guest = $_SESSION['guestName'];
                }

                echo <<<EOT
            <section class="backer-section">
            <h3>Bestellungen von #$guest</h3>
            <div id="status-block">

        EOT;
                foreach($data as $order){
                    $orderID = htmlspecialchars($order->orderID);
                    $name = htmlspecialchars($order->name);
                    echo <<<EOT
                    <div class="pizza-kunde">
                    <p>Bestellung #{$orderID} - Pizza {$name}</p>
                    <table>
        EOT;
                    $this->createRadioButton($order->status, "bestellt", 0);
                    $this->createRadioButton($order->status, "Im Offen", 1);
                    $this->createRadioButton($order->status, "fertig", 2);
                    $this->createRadioButton($order->status, "unterwegs", 3);
                    $this->createRadioButton($order->status, "geliefert", 4);
                    echo "</table>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</section>";
            }

            $this->generatePageFooter();
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    private function createRadioButton($status, $nameStatus, $value):void {
        $check = ($status == $value)? "checked" : "";
        $name = htmlspecialchars($nameStatus);
        echo <<<EOT
        <tr>
            <td><label for="status-$value">$name</label><br></td>
            <td><input type="radio" id="status-$value" $check value="$value" onclick="return false;" /></td>
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
            $page = new Kunde();
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
Kunde::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >