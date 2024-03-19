<?php

//
// DATABASEFACTORY.PHP
// File containing factory FOR database connection.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Model;

USE SimpleHosting\Application;
USE SimpleHosting\Model\ConnectionModel;

/**
 * CLASS which provides connections to the database.
 */
CLASS DatabaseFactory{

    /**
     * Model of connection to the database.
     */
    PRIVATE STATIC ConnectionModel $connectionModel;

    /**
     * Actual connection to the database.
     */
    PRIVATE STATIC ?\PgSql\Connection $connection = NULL;

    /**
     * Sets model of connection to the database.
     * @param ConnectionModel $connectionModel NEW model of connection to the database.
     */
    PUBLIC STATIC FUNCTION setModel(ConnectionModel $connectionModel){
        DatabaseFactory::$connectionModel = $connectionModel;
    }

    /**
     * Gets connection string.
     * @RETURN string String used to connect to the database.
     */
    PRIVATE STATIC FUNCTION getConnectionString(): string{
        RETURN 
            "host=" . DatabaseFactory::$connectionModel.getHost() . " " .
            "dbname=" . DatabaseFactory::$connectionModel.getDatabase() . " " .
            "user=" . DatabaseFactory::$connectionModel.getUsername() . " " .
            "password=" . DatabaseFactory::$connectionModel.getPassword();
    }

    /**
     * Gets conncection to the database.
     * @RETURN \PgSql\Connection Connection to the database.
     */
    PUBLIC STATIC FUNCTION get(): \PgSql\Connection{
        IF (DatabaseFactory::$connection == NULL){
            DatabaseFactory::$connection = pg_connect(DatabaseFactory::getConnectionString());
            IF ($connection == false){
                Application::logger()->error("Connection to database failed!");
            }
        }
        RETURN DatabaseFactory::$connection;
    }

    /**
     * Closes connection to the database.
     */
    PUBLIC STATIC FUNCTION close(): void{
        IF (DatabaseFactory::$connection != NULL){
            pg_close(DatabaseFactory::$connection);
        }
    }
}

?>
