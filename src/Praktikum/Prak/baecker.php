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

class Baecker extends Page
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

        $query = "select article.name, article.picture, article.price, ordered_article.ordered_article_id, ordered_article.ordering_id, ordered_article.status from article join ordered_article where article.article_id = ordered_article.article_id and ordered_article.status < 3 and ordered_article.ordering_id = {$guest} order by ordered_article.ordered_article_id ";

        $records = $this->_database->query($query);
        if(!$records){
            throw new Exception("Query failed: " . $this->_database->error);
        }

        while($record = $records->fetch_assoc()){
            $order = new Order_Product($record['name'], $record['ordered_article_id'], $record['ordering_id'],
                                        $record['picture'], $record['price'], $record['status']);
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
        try {
            $data = $this->getViewData(); // NOSONAR ignore unused $data
            $this->generatePageHeader('Bäcker');

            echo <<<EOT
        <section class="backer-section">
            <h3>Bestellungsliste</h3>
        EOT;

            if(sizeof($data) == 0){
                echo "<h4>Es gibt keine Bestellungen</h4>";
            }
            else{
                echo <<<EOT
                <form action="baecker.php" id="form_backer" accept-charset="UTF-8" method="post" class="form-baecker">
        EOT;
                foreach($data as $order){
                    $orderID = htmlspecialchars($order->orderID);
                    $name = htmlspecialchars($order->name);
                    echo <<<EOT
            <div class="pizza-baecker">
                <p>Bestellung #{$orderID} - Pizza {$name}</p>
                <table>
        EOT;
                    $this->createRadioInput($orderID, $order->status, "bestellt", 0);
                    $this->createRadioInput($orderID, $order->status, "Im Offen", 1);
                    $this->createRadioInput($orderID, $order->status, "fertig", 2);
                    echo <<<EOT
                </table>
            </div>
        EOT;

                }
                echo "</form>";
                echo "</section>";
            }

            // to do: output view of this page using $data
            $this->generatePageFooter();
        } 
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    private function createRadioInput($Id, $status, $statusName, $value): void
    {
        $check = ($status == $value) ? "checked" : "";
        $name = htmlspecialchars($statusName);

        echo <<<EOT
            <tr>
                <td><label for="status-$Id-$value">$name</label><br></td>
                <td><input type="radio" name="statuses[$Id]" id="status-$Id-$value" value="$value" $check onclick="document.forms['form_backer'].submit()"/></td>
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
            foreach ($statuses as $id => $Status){
                $id = $this->_database->real_escape_string((string)$id);
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
            $page = new Baecker();
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
Baecker::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >