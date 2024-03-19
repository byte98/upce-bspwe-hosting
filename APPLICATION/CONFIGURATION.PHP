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

use SimpleHosting\Model\ConnectionModel;
use SimpleHosting\Utils\Logger\LoggerSettings;
use SimpleHosting\Utils\Logger\LogLevel;

/**
 * Class which manages configuration of application.
 */
class Configuration{

    /**
     * Path to file with configuration.
     */
    private string $confFile;

    /**
     * Settings of logger.
     */
    private LoggerSettings $loggerSettings;

    /**
     * Flag, whether PHP errors should be visible or not.
     */
    private bool $PHPErrors = false;

    /**
     * Model of connection to the database.
     */
    private ConnectionModel $connection;

    /**
     * Routing table.
     */
    private array $routes;

    /**
     * Creates new manager of configuration.
     * @param string $confFile Path to YAML file with configuration.
     */
    public function __construct(string $confFile){
        $this->confFile = $confFile;
        $this->loggerSettings = new LoggerSettings(
            true, "./logs/", LogLevel::Warning, false, false);
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
            if (array_key_exists("PHPErrors", $conf) && gettype($conf["PHPErrors"]) == "boolean"){$this->PHPErrors = $conf["PHPErrors"];}
            $this->readLogger($conf);
            $this->readConnection($conf);
            $this->readRoutes($conf);
        }
    }

    /**
     * Reads logger settings.
     * @param array $conf Parsed configuration from file.
     */
    private function readLogger(array $conf){
        $log = $this->loggerSettings->getLog();
        $logDir = $this->loggerSettings->getLogPath();
        $logLevel = $this->loggerSettings->getLogLevel();
        $logStdout = $this->loggerSettings->getStdout();
        $logUnicode = $this->loggerSettings->getUnicode();

        if (array_key_exists("Log", $conf) && gettype($conf["Log"]) == "boolean"){$log = $conf["Log"];}
        if (array_key_exists("LogPath", $conf) && gettype($conf["LogPath"]) == "string"){$logDir = $conf["LogPath"];}
        if (array_key_exists("LogLevel", $conf) && gettype($conf["LogLevel"]) == "string" && LogLevel::fromString($conf["LogLevel"]) != NULL){$logLevel = LogLevel::fromString($conf["LogLevel"]);}
        if (array_key_exists("LogStdout", $conf) && gettype($conf["LogStdout"]) == "boolean"){$logStdout = $conf["LogStdout"];}
        if (array_key_exists("LogUnicode", $conf) && gettype($conf["LogUnicode"]) == "boolean"){$logUnicode = $conf["LogUnicode"];}

        $this->loggerSettings = new LoggerSettings(
            $log, $logDir, $logLevel, $logStdout, $logUnicode
        );
    }
    

    /**
     * Reads connection information from file.
     * @param array $conf Parsed configuration from file.
     */
    private function readConnection(array $conf): void{
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
     * Reads routes form configuration file.
     * @param array $conf Parsed configuration from file.
     */
    private function readRoutes(array $conf): void{
        if (array_key_exists("Routes", $conf) && gettype($conf["Routes"]) == "array"){
            $this->routes = $conf["Routes"];
        }
    }

    /**
     * Gets settings of logger.
     * @return LoggerSettings Settings of logger.
     */
    public function getLoggerSettings(): LoggerSettings{
        return $this->loggerSettings;
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

    /**
     * Gets routes from configuration file.
     * @return array Routes from configuration file,
     *               where keys are paths and values are names
     *               of classes.
     */
    public function getRoutes(): array{
        return $this->routes;
    }

}

?>
