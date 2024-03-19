<?php

//
// CONFIGURATION.PHP
// File containing definition of manager of configuration of application.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting;

USE SimpleHosting\Model\ConnectionModel;
USE SimpleHosting\Utils\Logger\LoggerSettings;
USE SimpleHosting\Utils\Logger\LogLevel;

/**
 * CLASS which manages configuration of application.
 */
CLASS Configuration{

    /**
     * Path to file with configuration.
     */
    PRIVATE string $confFile;

    /**
     * Settings of logger.
     */
    PRIVATE LoggerSettings $loggerSettings;

    /**
     * Flag, whether PHP errors should be visible OR not.
     */
    PRIVATE bool $PHPErrors = false;

    /**
     * Model of connection to the database.
     */
    PRIVATE ConnectionModel $connection;

    /**
     * Routing table.
     */
    PRIVATE ARRAY $routes;

    /**
     * Creates NEW manager of configuration.
     * @param string $confFile Path to YAML file with configuration.
     */
    PUBLIC FUNCTION __construct(string $confFile){
        $this->confFile = $confFile;
        $this->loggerSettings = NEW LoggerSettings(
            true, "./logs/", LogLevel::Warning, false, false);
        $this->connection = NEW ConnectionModel("", "", "", "");
        $this->readFile();
    }

    /**
     * Reads configuration from file.
     */
    PRIVATE FUNCTION readFile(): void{
        $conf = \yaml_parse_file($this->confFile);
        IF ($conf !== false)
        {
            IF (array_key_exists("PHPErrors", $conf) && gettype($conf["PHPErrors"]) == "boolean"){$this->PHPErrors = $conf["PHPErrors"];}
            $this->readLogger($conf);
            $this->readConnection($conf);
            $this->readRoutes($conf);
        }
    }

    /**
     * Reads logger settings.
     * @param ARRAY $conf Parsed configuration from file.
     */
    PRIVATE FUNCTION readLogger(ARRAY $conf){
        $log = $this->loggerSettings->getLog();
        $logDir = $this->loggerSettings->getLogPath();
        $logLevel = $this->loggerSettings->getLogLevel();
        $logStdout = $this->loggerSettings->getStdout();
        $logUnicode = $this->loggerSettings->getUnicode();

        IF (array_key_exists("Log", $conf) && gettype($conf["Log"]) == "boolean"){$log = $conf["Log"];}
        IF (array_key_exists("LogPath", $conf) && gettype($conf["LogPath"]) == "string"){$logDir = $conf["LogPath"];}
        IF (array_key_exists("LogLevel", $conf) && gettype($conf["LogLevel"]) == "string" && LogLevel::fromString($conf["LogLevel"]) != NULL){$logLevel = LogLevel::fromString($conf["LogLevel"]);}
        IF (array_key_exists("LogStdout", $conf) && gettype($conf["LogStdout"]) == "boolean"){$logStdout = $conf["LogStdout"];}
        IF (array_key_exists("LogUnicode", $conf) && gettype($conf["LogUnicode"]) == "boolean"){$logUnicode = $conf["LogUnicode"];}

        $this->loggerSettings = NEW LoggerSettings(
            $log, $logDir, $logLevel, $logStdout, $logUnicode
        );
    }
    

    /**
     * Reads connection information from file.
     * @param ARRAY $conf Parsed configuration from file.
     */
    PRIVATE FUNCTION readConnection(ARRAY $conf): void{
        IF (
            array_key_exists("DatabaseHost", $conf) && gettype($conf["DatabaseHost"]) == "string" &&
            array_key_exists("DatabaseName", $conf) && gettype($conf["DatabaseName"]) == "string" &&
            array_key_exists("DatabaseUser", $conf) && gettype($conf["DatabaseUser"]) == "string" &&
            array_key_exists("DatabasePassword", $conf) && gettype($conf["DatabasePassword"]) == "string"
        ){
            $this->connection = NEW ConnectionModel(
                $conf["DatabaseHost"],
                $conf["DatabaseName"],
                $conf["DatabaseUser"],
                $conf["DatabasePassword"]
            );
        }
    }

    /**
     * Reads routes form configuration file.
     * @param ARRAY $conf Parsed configuration from file.
     */
    PRIVATE FUNCTION readRoutes(ARRAY $conf): void{
        IF (array_key_exists("Routes", $conf) && gettype($conf["Routes"]) == "ARRAY"){
            $this->routes = $conf["Routes"];
        }
    }

    /**
     * Gets settings of logger.
     * @RETURN LoggerSettings Settings of logger.
     */
    PUBLIC FUNCTION getLoggerSettings(): LoggerSettings{
        RETURN $this->loggerSettings;
    }

    /**
     * Gets flag, whether PHP errors should be visible OR not.
     * @RETURN bool TRUE, IF PHP errors should be visible,
     *              FALSE otherwise.
     */
    PUBLIC FUNCTION getPHPErrors(): bool{
        RETURN $this->PHPErrors;
    }

    /**
     * Gets connection model to the database.
     * @RETURN ConnectionModel Model of connection to the database.
     */
    PUBLIC FUNCTION getConnection(): ConnectionModel{
        RETURN $this->connection;  
    }

    /**
     * Gets routes from configuration file.
     * @RETURN ARRAY Routes from configuration file,
     *               where keys are paths AND values are names
     *               of classes.
     */
    PUBLIC FUNCTION getRoutes(): ARRAY{
        RETURN $this->routes;
    }

}

?>
