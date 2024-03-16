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


namespace SimpleHosting\Utils\Logger;

use SimpleHosting\Utils\StringUtils;

/**
 * Enumeration of all available log levels.
 */
enum LogLevel{

    /**
     * Lowest level of log.
     */
    case Low;

    /**
     * Base level of log.
     */
    case Base;

    /**
     * Log providing some important information.
     */
    case Info;

    /**
     * Log warning about something.
     */
    case Warning;

    /**
     * Log informing about error.
     */
    case Error;

    /**
     * Gets string representation of log level.
     * @return string String representing log level.
     */
    public function toString(): string{
        $reti = "";
        switch($this){
            case LogLevel::Low:     $reti = "LOW";     break;
            case LogLevel::Base:    $reti = "BASE";    break;
            case LogLevel::Info:    $reti = "INFO";    break;
            case LogLevel::Warning: $reti = "WARNING"; break;
            case LogLevel::Error:   $reti = "ERROR";   break;  
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
            case "LOW":     $reti = LogLevel::Low;     break;
            case "BASE":    $reti = LogLevel::Base;    break;
            case "INFO":    $reti = LogLevel::Info;    break;
            case "WARNING": $reti = LogLevel::Warning; break;
            case "ERROR":   $reti = LogLevel::Error;   break;
        }
        return $reti;
    }
}

?>
