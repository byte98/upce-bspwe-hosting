<?php

//
// CONNECTIONMODEL.PHP
// File containing definition of model of connection
// to the database.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Model;

/**
 * Utility class to store information about
 * connection to the database.
 */
class ConnectionModel{

    /**
     * Address or hostname of database.
     */
    private string $host;

    /**
     * Name of database.
     */
    private string $database;

    /**
     * Name of user with access to database.
     */
    private string $username;


    /**
     * Password of user with access to database.
     */
    private string $password;

    /**
     * Creates new model of connection to the database.
     * @param string $host Address or hostname of database.
     * @param string $database Name of database.
     * @param string $username Name of user with access to database.
     * @param string $password Password of user with access to database.
     */
    public function __construct(string $host, string $database, string $username, string $password){
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Gets address or hostname of database.
     * @return string Address or hostname of database.
     */
    public function getHost(): string{
        return $this->host;
    }

    /**
     * Gets name of database.
     * @return string Name of database.
     */
    public function getDatabase(): string{
        return $this->database;
    }

    /**
     * Gets name of user with access to database.
     * @return string Name of user with access to database.
     */
    public function getUsername(): string{
        return $this->username;
    }

    /**
     * Gets password of user with access to database.
     * @return string Password of user with access to database.
     */
    public function getPassword(): string{
        return $this->password;
    }
}


?>
