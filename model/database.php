<?php
$user = $_SERVER['USER'];
require "/home/$user/config.php";

/**
 * 05/23/2019
 * Class Database represents an instance of a database
 *
 * The class Databse creates a connection from remote site to a database,
 * if connection is successful the user can retrieve order information from the database.
 *
 * @authors Maria Gallardo <mgallardo3@mail.greenriver.edu>,Kat Truitt <ktruitt@mail.greenriver.edu>
 * @copyright 2019
 */
class Database
{
    private $_dbh;

    /**
     * Database constructor with nor parameters, runs the connect method when instantiated
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * This createa a connection to databse and returns an error if connection was not successful
     * @return PDO returns the connection
     */
    function connect()
    {
        try{

            //instantiate a db object
            $this->_dbh = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
            //echo '<h1>connected to db</h1>';
            return $this->_dbh;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * This function adds a request to the database
     * @return mixed void return void
     */
    function insertRequest()
    {
        global $f3;

        $fname = $f3->get('fname');
        $lname = $f3->get('lname');
        $email = $f3->get('email');
        $phone = $f3->get('phone');
        $event = strtolower($f3->get('event_type'));
        $tour_date = $f3->get('tour_date');
        $start_time= $f3->get('start_time');
        $confirm = false;

//        echo 'event type: ' . $event . ' first name: ' . $fname . ' last name: ' . $lname.
//            ' tour: ' .$tour .' email '. $email .' phone: '. $phone;

        //1. Create sql query
        $sql = "SET @event = (SELECT event_id FROM packages WHERE event_type =:event) ;
                INSERT into requests VALUES (order_id, NOW(), :fname,:lname,:email,:phone,:tour_date,:start_time,
                :confirm,@event);";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind parameters
        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_INT);
        $statement->bindParam(':event', $event, PDO::PARAM_STR);
        $statement->bindParam(':tour_date', $tour_date, PDO::PARAM_STR);
        $statement->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $statement->bindParam(':confirm', $confirm, PDO::PARAM_BOOL);

        //4. execute the statement
        $statement->execute();
    }

    /**
     * This function inserts customized orders to the database
     * @return void
     */
    function insertCustomizedOrder()
    {
        global $f3;
        //Get event object
        $eventObject= $f3->get('event');
        //Get request type
        $event = $f3->get('event_type');
        //Retrieve last insert query
        $latest = $this->_dbh->lastInsertId();
        //Get event object data
        $transportation = $eventObject->getTransportation();
        $description = $eventObject->getDescription();
        $name = $eventObject->getName();

//        echo 'event_type: '. $event .' event object: '. $eventObject .' event name: ' . $name .
//            ' transportation: ' . $transportation .
//            ' description: ' . $description;

        //1. Create sql query
        $sql2= "SET @event = (SELECT event_id FROM packages WHERE event_type =:event);
                INSERT INTO customized_order VALUES 
                (:latest, @event,:name,:description,:transportation )";

        //2. Prepare the statement
        $statement= $this->_dbh->prepare($sql2);

        //3. Bind parameters
        $statement->bindParam(':name',$name,PDO::PARAM_STR);
        $statement->bindParam(':description',$description,PDO::PARAM_STR);
        $statement->bindParam(':transportation',$transportation,PDO::PARAM_STR);
        $statement->bindParam(':event',$event,PDO::PARAM_INT);
        $statement->bindParam(':latest',$latest,PDO::PARAM_INT);

        //4. execute the statement
        $statement->execute();
    }

    /**
     * This sends a query request to the database and returns the result
     * @return String, returns the string result from the query request
     */
    function getPendingOrders()
    {
        //Define the query
        $sql = "SELECT * FROM requests;";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * This makes a request to the database and then returns information from
     * the user
     * @return String, returns the query from the database
     */
    function getAdmin($user)
    {
        //Define the query
        $sql = "SELECT user,pass FROM admin WHERE user=:user;";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':user', $user, PDO::PARAM_STR);

        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

}