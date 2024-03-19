<?php

//
// CONNECTIONMODEL.PHP
// File containing definition of model of connection
// to the database.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Model;

/**
 * Utility CLASS to store information about
 * connection to the database.
 */
CLASS ConnectionModel{

    /**
     * Address OR hostname of database.
     */
    PRIVATE string $host;

    /**
     * Name of database.
     */
    PRIVATE string $database;

    /**
     * Name of user with access to database.
     */
    PRIVATE string $username;


    /**
     * Password of user with access to database.
     */
    PRIVATE string $password;

    /**
     * Creates NEW model of connection to the database.
     * @param string $host Address OR hostname of database.
     * @param string $database Name of database.
     * @param string $username Name of user with access to database.
     * @param string $password Password of user with access to database.
     */
    PUBLIC FUNCTION __construct(string $host, string $database, string $username, string $password){
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Gets address OR hostname of database.
     * @RETURN string Address OR hostname of database.
     */
    PUBLIC FUNCTION getHost(): string{
        RETURN $this->host;
    }

    /**
     * Gets name of database.
     * @RETURN string Name of database.
     */
    PUBLIC FUNCTION getDatabase(): string{
        RETURN $this->database;
    }

    /**
     * Gets name of user with access to database.
     * @RETURN string Name of user with access to database.
     */
    PUBLIC FUNCTION getUsername(): string{
        RETURN $this->username;
    }

    /**
     * Gets password of user with access to database.
     * @RETURN string Password of user with access to database.
     */
    PUBLIC FUNCTION getPassword(): string{
        RETURN $this->password;
    }
}


?>
