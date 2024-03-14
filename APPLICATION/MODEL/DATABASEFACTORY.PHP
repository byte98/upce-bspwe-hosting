<?php

//
// DATABASEFACTORY.PHP
// File containing factory for database connection.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Model;

use SimpleHosting\Application;
use SimpleHosting\Model\ConnectionModel;

/**
 * Class which provides connections to the database.
 */
class DatabaseFactory{

    /**
     * Model of connection to the database.
     */
    private static ConnectionModel $connectionModel;

    /**
     * Actual connection to the database.
     */
    private static ?\PgSql\Connection $connection = NULL;

    /**
     * Sets model of connection to the database.
     * @param ConnectionModel $connectionModel New model of connection to the database.
     */
    public static function setModel(ConnectionModel $connectionModel){
        DatabaseFactory::$connectionModel = $connectionModel;
    }

    /**
     * Gets connection string.
     * @return string String used to connect to the database.
     */
    private static function getConnectionString(): string{
        return 
            "host=" . DatabaseFactory::$connectionModel.getHost() . " " .
            "dbname=" . DatabaseFactory::$connectionModel.getDatabase() . " " .
            "user=" . DatabaseFactory::$connectionModel.getUsername() . " " .
            "password=" . DatabaseFactory::$connectionModel.getPassword();
    }

    /**
     * Gets conncection to the database.
     * @return \PgSql\Connection Connection to the database.
     */
    public static function get(): \PgSql\Connection{
        if (DatabaseFactory::$connection == NULL){
            DatabaseFactory::$connection = pg_connect(DatabaseFactory::getConnectionString());
            if ($connection == false){
                Application::logger()->error("Connection to database failed!");
            }
        }
        return DatabaseFactory::$connection;
    }

    /**
     * Closes connection to the database.
     */
    public static function close(): void{
        if (DatabaseFactory::$connection != NULL){
            pg_close(DatabaseFactory::$connection);
        }
    }
}

?>
