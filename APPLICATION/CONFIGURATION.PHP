<?php

//
// CONFIGURATION.PHP
// File containing definition of manager of configuration of application.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting;

use SimpleHosting\LogLevel;
use SimpleHosting\Model\ConnectionModel;

/**
 * Class which manages configuration of application.
 */
class Configuration{

    /**
     * Path to file with configuration.
     */
    private string $confFile;

    /**
     * Flag, whether application should create logs.
     */
    private bool $log = true;

    /**
     * Path to directory, to which logs will be created.
     */
    private string $logDir = "./";

    /**
     * Minimal level of logs.
     */
    private LogLevel $logLevel = LogLevel::WARNING;

    /**
     * Flag, whether PHP errors should be visible or not.
     */
    private bool $PHPErrors = false;

    /**
     * Model of connection to the database.
     */
    private ConnectionModel $connection;

    /**
     * Creates new manager of configuration.
     * @param string $confFile Path to YAML file with configuration.
     */
    public function __construct(string $confFile){
        $this->confFile = $confFile;
        $this->connection = new ConnectionModel("", "", "", "");
        $this->readFile();
    }

    /**
     * Reads configuration from file.
     */
    private function readFile(): void{
        $conf = \yaml_parse_file($this->confFile);
        if ($conf !== false)
        {
            if (array_key_exists("Log", $conf) && gettype($conf["Log"]) == "boolean"){$this->log = $conf["Log"];}
            if (array_key_exists("LogPath", $conf) && gettype($conf["LogPath"]) == "string"){$this->logDir = $conf["LogPath"];}
            if (array_key_exists("LogLevel", $conf) && gettype($conf["LogLevel"]) == "string" && LogLevel::fromString($conf["LogLevel"]) != NULL){$this->logLevel = LogLevel::fromString($conf["LogLevel"]);}
            if (array_key_exists("PHPErrors", $conf) && gettype($conf["PHPErrors"]) == "boolean"){$this->PHPErrors = $conf["PHPErrors"];}
            $this->readConnection($conf);
        }
    }
    

    /**
     * Reads connection information from file.
     * @param mixed $conf Parsed configuration from file.
     */
    private function readConnection(mixed $conf): void{
        if (
            array_key_exists("DatabaseHost", $conf) && gettype($conf["DatabaseHost"]) == "string" &&
            array_key_exists("DatabaseName", $conf) && gettype($conf["DatabaseName"]) == "string" &&
            array_key_exists("DatabaseUser", $conf) && gettype($conf["DatabaseUser"]) == "string" &&
            array_key_exists("DatabasePassword", $conf) && gettype($conf["DatabasePassword"]) == "string"
        ){
            $this->connection = new ConnectionModel(
                $conf["DatabaseHost"],
                $conf["DatabaseName"],
                $conf["DatabaseUser"],
                $conf["DatabasePassword"]
            );
        }
    }

    /**
     * Gets flag, whether application should create logs.
     * @return bool TRUE, if application should create logs,
     *              FALSE otherwise.
     */
    public function getLog(): bool{
        return $this->log;
    }

    /**
     * Gets path to directory, to which logs will be created.
     * @return string Path to directory, to which logs will be created.
     */
    public function getLogDir(): string{
        return $this->logDir;
    }

    /**
     * Gets minimal level of logs.
     * @return LogLevel Minimal level of logs.
     */
    public function getLogLevel(): LogLevel{
        return $this->logLevel;
    }

    /**
     * Gets flag, whether PHP errors should be visible or not.
     * @return bool TRUE, if PHP errors should be visible,
     *              FALSE otherwise.
     */
    public function getPHPErrors(): bool{
        return $this->PHPErrors;
    }

    /**
     * Gets connection model to the database.
     * @return ConnectionModel Model of connection to the database.
     */
    public function getConnection(): ConnectionModel{
        return $this->connection;  
    }

}

?>
