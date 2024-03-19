<?php

//
// LOGLEVEL.PHP
// File containing all available levels of logs.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//


NAMESPACE SimpleHosting\Utils\Logger;

USE SimpleHosting\Utils\StringUtils;

/**
 * Enumeration of all available log levels.
 */
enum LogLevel{

    /**
     * Lowest level of log.
     */
    CASE Low;

    /**
     * Base level of log.
     */
    CASE Base;

    /**
     * Log providing some important information.
     */
    CASE Info;

    /**
     * Log warning about something.
     */
    CASE Warning;

    /**
     * Log informing about error.
     */
    CASE Error;

    /**
     * Gets string representation of log level.
     * @RETURN string String representing log level.
     */
    PUBLIC FUNCTION toString(): string{
        $reti = "";
        SWITCH($this){
            CASE LogLevel::Low:     $reti = "LOW";     BREAK;
            CASE LogLevel::Base:    $reti = "BASE";    BREAK;
            CASE LogLevel::Info:    $reti = "INFO";    BREAK;
            CASE LogLevel::Warning: $reti = "WARNING"; BREAK;
            CASE LogLevel::Error:   $reti = "ERROR";   BREAK;  
        }
        RETURN $reti;
    }


    /**
     * Gets log level from string.
     * @param string $str String representation of log level.
     * @RETURN ?LogLevel Log level from its string representation,
     *                   OR NULL IF log level cannot be determined.
     */
    PUBLIC STATIC FUNCTION fromString(string $str): ?LogLevel{
        $reti = NULL;
        SWITCH(strtoupper(StringUtils::trim($str))){
            CASE "LOW":     $reti = LogLevel::Low;     BREAK;
            CASE "BASE":    $reti = LogLevel::Base;    BREAK;
            CASE "INFO":    $reti = LogLevel::Info;    BREAK;
            CASE "WARNING": $reti = LogLevel::Warning; BREAK;
            CASE "ERROR":   $reti = LogLevel::Error;   BREAK;
        }
        RETURN $reti;
    }
}

?>
