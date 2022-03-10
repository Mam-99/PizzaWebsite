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
require_once './Item/Article.php';

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
class Bestellung extends Page
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
        $pizzas = array();
        $query = "select * from article";

        $records = $this->_database->query($query);
        if(!$records){
            throw new Exception("Query failed: " . $this->_database->error);
        }

        while($record = $records->fetch_assoc()){
            $article = new Article($record["article_id"], $record["name"], $record["picture"], $record["price"]);

            $pizzas[$record["article_id"]] = $article;
        }
        $records->free();
        return $pizzas;
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
            $this->generatePageHeader('Pizza Service');

            echo <<<EOT
        <section class="main">
        <section class="order-top">
        <h2 class="speisekarte">Speisekarte</h2>
        <div class="pizza-menu">
    EOT;

            // to do: output view of this page using $data
            if(sizeof($data) == 0){
                echo "<h4>Es gibt keine Pizza</h4>";
            }

            foreach ($data as $pizza){
                $picture = htmlspecialchars($pizza->picture);
                $name = htmlspecialchars($pizza->name);
                $price = htmlspecialchars($pizza->price);
                $id = htmlspecialchars($pizza->id);
                echo <<<EOT
            <div class="Pizza">
                <img src="$picture" alt="Pizza {$name}"
                    width="300" height="200">
                <div class="pizza-info">
                    <p>$name</p>
                    <p>$price EUR</p> 
                    <p><button onclick="addPizza({id: '$id', name: '$name', price: '$price'})">In den Warenkorb</button></p>
                </div>
            </div>
    EOT;

            }

            echo <<<EOT
            </div>
        </section>
    
        <section class="order-right">
            <h2>Warenkorb</h2>
            <div id="cart">
                <div id="placeholder">Keine Artikel</div>
            </div>
            <button type="reset" onclick="deleteAll()">Alles Löschen</button>
            <p>Preis: <span id="total-price"></span> €</p>
        </section>
    
        <section class="order-right">
        <form action="bestellungseite.php" method="post" accept-charset="UTF-8">
            <h2>Ihre Daten</h2>
            <table>
                <tr>
                    <td><label>Vorname </label></td>
                    <td><input type="text" name="vorname" required /><br></td>
                </tr>
                <tr>
                    <td><label>Nachname</label></td>
                    <td><input type="text" name="nachname" required /><br></td>
                </tr>
                <tr>
                    <td><label>Straße/HausNr </label></td>
                    <td><input type="text" name="adress" required /><br></td>
                </tr>
                <tr>
                    <td><label>Plz </label></td>
                    <td><input type="text" name="plz" required /><br></td>
                </tr>
                <tr>
                    <td><label>Stadt </label></td>
                    <td><input type="text" name="stadt" required /><br><br></td>
                </tr>                       
            </table>
            <button type="submit" name="submit" class="send-button">Jetzt bestellen</button>
            <input type="hidden" id="cart-hidden" name="cart" value="[]"/>
        </form>
        </section>
        </section>
        <script src="Script/bestellen.js"></script>
    EOT;

            $this->generatePageFooter();
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Processes the data that comes via GET or POST.
     * If this page is supposed to do something with submitted
     * data do it here.
     * @return void
     */
    protected function processReceivedData():void
    {
        try {
            parent::processReceivedData();
            // to do: call processReceivedData() for all members
            if (isset($_POST['vorname']) && isset($_POST['nachname']) && isset($_POST['adress'])
                && isset($_POST['plz']) && isset($_POST['stadt']) && isset($_POST["cart"])) {
                $address = $_POST['adress'] . ', ' . $_POST['plz'] . ' ' . $_POST['stadt'] . ', ' . $_POST['vorname'];
                $time = date('d-m-y h:i:s');

                $escapedAddress = $this->_database->real_escape_string($address);
                $query = "insert into ordering values(NULL, '$escapedAddress', '$time')";
                $recordSet = $this->_database->query($query);
                if (!$recordSet) {
                    throw new Exception("Query failed: " . $this->_database->error);
                }

                $_SESSION['guestName'] = $_POST['vorname'];
                $ordering_id = $this->_database->insert_id; // Get id from the last insert
                $_SESSION['guestID'] = $ordering_id;

                // To do: insert this order to table ordered_article_id
                // ordered_article (ordered_article_id, ordering_id, article_id, status)
                $cart = json_decode($_POST["cart"]); // $_POST["cart"] ist ein Array, in dem ID von ausgewählten Article beinhaltet werden
                foreach ($cart as $cart_item){
                    $addQuery = "insert into ordered_article values(NULL, $ordering_id, $cart_item, 0)";
                    $recordSet = $this->_database->query($addQuery);
                    if(!$recordSet){
                        throw new Exception("Query failed: " . $this->_database->error);
                    }
                }

                // TO DO: using function header() to location to kunde.php
                header("Location: kunde.php");
                die();
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
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
            $page = new Bestellung();
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
Bestellung::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >