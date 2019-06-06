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
     * @return mixed void
     */
    function insertRequest()
    {
        global $f3;
//        $order_id = $f3->get('order_id');
//        $purchase_date= $f3->get('purchase_id');
        $fname=$f3->get('fname');
        $lname = $f3->get('lname');
        $reserve = $f3->get('reserve');
        $email = $f3->get('email');
        $phone = $f3->get('phone');
//        $confirm = $f3->get('confirm');
//        $event_id = $f3->get('event_id');

        //1. define the query
        $sql = "INSERT INTO requests(fname,lname,reserve,email,phone)
                    VALUES(:fname,:lname,:reserve,:email,:phone)";

        //2. prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. bind parameters
//        $statement->bindParam(':order_id', $order_id, PDO::PARAM_INT);
//        $statement->bindParam(':purchase_date', $purchase_date, PDO::PARAM_INT);
        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':reserve', $reserve, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
//        $statement->bindParam(':confirm', $confirm, PDO::PARAM_STR);
//        $statement->bindParam(':event_id', $event_id, PDO::PARAM_INT);

        //4. execute the statement
        $statement->execute();

        //5. return the result
         echo '<h1> it worked</h1>';
    }

    /**
     *
     */
    function insertEvent()
    {

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