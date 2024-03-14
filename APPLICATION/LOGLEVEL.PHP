<?php

//
// LOGLEVEL.PHP
// File containing all available levels of logs.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//


namespace SimpleHosting;

use SimpleHosting\Utils\StringUtils;

/**
 * Enumeration of all available log levels.
 */
enum LogLevel{

    /**
     * Base level of log.
     */
    case BASE;

    /**
     * Log providing some important information.
     */
    case INFO;

    /**
     * Log warning about something.
     */
    case WARNING;

    /**
     * Log informing about error.
     */
    case ERROR;

    /**
     * Gets string representation of log level.
     * @return string String representing log level.
     */
    public function toString(): string{
        $reti = "";
        switch($this){
            case LogLevel::BASE:    $reti = "BASE";    break;
            case LogLevel::INFO:    $reti = "INFO";    break;
            case LogLevel::WARNING: $reti = "WARNING"; break;
            case LogLevel::ERROR:   $reti = "ERROR";   break;  
        }
        return $reti;
    }


    /**
     * Gets log level from string.
     * @param string $str String representation of log level.
     * @return ?LogLevel Log level from its string representation,
     *                   or NULL if log level cannot be determined.
     */
    public static function fromString(string $str): ?LogLevel{
        $reti = NULL;
        switch(strtoupper(StringUtils::trim($str))){
            case "BASE":    $reti = LogLevel::BASE;    break;
            case "INFO":    $reti = LogLevel::INFO;    break;
            case "WARNING": $reti = LogLevel::WARNING; break;
            case "ERROR":   $reti = LogLevel::ERROR;   break;
        }
        return $reti;
    }
}

?>
