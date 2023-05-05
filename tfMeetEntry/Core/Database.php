<?php

//Set the namespace of the class
namespace Core;

//Import the PDO class
use PDO;

class Database
{
    //Declare a connection and statement variable that stores the connection to the database and the statement to be run
    public $connection;
    public $statement;

    //Create a connection to the database when a new Database object is created
    public function __construct($config, $username = 'root', $password = '')
    {
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    //Execute the input query using the given parameters
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    //Return all the information from executing the query
    public function get()
    {
        return $this->statement->fetchAll();
    }

    //Return one piece of the information from executing the query
    public function find()
    {
        return $this->statement->fetch();
    }

    //Return one piece of the information from executing the query if it found anything at all
    public function findOrFail()
    {
        $result = $this->find();

        if (! $result) {
            abort();
        }

        return $result;
    }

    //Run the given query and return all results
    public function results($query, $params = []){
        return $this->query($query,$params)->get();
    }
    
    //Return the month from the given date using the months table in the database
    //This is assuming the input date is a string
    public function month($date){
        $month = substr($date,5,2);
        return ($this->query("SELECT month FROM months WHERE num = {$month}")->get())[0]['month'];
    }
}
