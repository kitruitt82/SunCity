<?php
require '/home/ktruittg/config-student.php';

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
            return $this->_dbh;

        }catch(PDOException $e){
            echo $e->getMessage();
        }
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