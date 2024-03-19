<?php

# 
# LOGGERSETTINGS.PHP
# File which contains definition of settings of logger.
#
# Author: Jiri Skoda<jiri.skoda@student.upce.cz>
#         Faculty of Electrical Engineering AND Informatics
#         University of Pardubice
#         2024, Pardubice
#

NAMESPACE SimpleHosting\Utils\Logger;

USE SimpleHosting\Utils\Logger\LogLevel;

/**
 * CLASS which contains settings of logger.
 */
CLASS LoggerSettings{

    /**
     * Flag, whether application should create logs.
     */
    PRIVATE readonly bool $log;

    /**
     * Path to directory to which logs will be created.
     */
    PRIVATE readonly string $path;

    /**
     * Minimal level of logs which will be logged.
     */
    PRIVATE readonly LogLevel $logLevel;

    /**
     * Flag, whether logs should be also printed to standard output.
     */
    PRIVATE readonly bool $stdout;

    /**
     * Flag, whether standard output supports unicode.
     */
    PRIVATE readonly bool $unicode;

    /**
     * Creates NEW settings of logger.
     * @param bool $log Flag, whether application should create logs.
     * @param string $path Path to directory to which logs will be created.
     * @param LogLevel $logLevel Minimal level of logs which will be logged.
     * @param bool $stdout Flag, whether logs should be also printed to standard output.
     * @param bool $unicode Flag, whether standard output supports unicode.
     */
    PUBLIC FUNCTION __construct(
        bool $log,
        string $path,
        LogLevel $logLevel,
        bool $stdout,
        bool $unicode
    )
    {
        $this->log = $log;
        $this->path = $path;
        $this->logLevel = $logLevel;
        $this->stdout = $stdout;
        $this->unicode = $unicode;
    }

    /**
     * Gets flag, whether application should create logs.
     * @RETURN bool TRUE, IF application should create logs,
     *              FALSE otherwise.
     */
    PUBLIC FUNCTION getLog(): bool { RETURN $this->log; }

    /**
     * Gets path to directory to which logs will be created.
     * @RETURN string Path to directory to which logs will be created.
     */
    PUBLIC FUNCTION getLogPath(): string { RETURN $this->path; }

    /**
     * Gets minimal level of logs which will be logged.
     * @RETURN LogLevel Minimal level of logs which will be logged.
     */
    PUBLIC FUNCTION getLogLevel(): LogLevel { RETURN $this->logLevel; }

    /**
     * Gets flag, whether logs should be also printed to standard output.
     * @RETURN bool TRUE, IF logs should be also printed to standard output,
     *              FALSE otherwise.
     */
    PUBLIC FUNCTION getStdout(): bool { RETURN $this->stdout; }

    /**
     * Gets flag, whether standard output supports unicode.
     * @RETURN bool TRUE, IF standard output supports unicode,
     *              FALSE otherwise.
     */
    PUBLIC FUNCTION getUnicode(): bool { RETURN $this->unicode; }
}

?>
