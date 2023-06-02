<?php

/* Name: Huixin Xu
Due Date: Apr 10, 2023
Section: CST8285 313
Lab: 23W Assignment2
File: abstractDAO.php
Lab objective: Create PHP server web pages corresponding to CRUD operations for one entity.
*/

//Used to throw mysqli_sql_exceptions for database errors instead or printing them to the screen.
mysqli_report(MYSQLI_REPORT_STRICT);

/**
 * Abstract data access class. Holds all of the database
 * connection information, and initializes a mysqli object
 * on instantiation.
 */
class abstractDAO {
    protected $mysqli;

    protected static $DB_HOST = "localhost"; // Host address for the database

    /* Port number on the host */
    protected static $DB_PORT = 3306;
    /* Database username */
    protected static $DB_USERNAME = "appuser";
    /* Database password */
    protected static $DB_PASSWORD = "password";
    /* Name of database */
    protected static $DB_DATABASE = "movie";


    /*
     * Constructor. Instantiates a new MySQLi object.
     * Throws an exception if there is an issue connecting
     * to the database.
     */
    function __construct() {
        try{
            $this->mysqli = new mysqli(self::$DB_HOST, self::$DB_USERNAME, self::$DB_PASSWORD, self::$DB_DATABASE, self::$DB_PORT);
        } //populate the new mysqli object
        catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function getMysqli() {
        return $this->mysqli;
    }

}

?>