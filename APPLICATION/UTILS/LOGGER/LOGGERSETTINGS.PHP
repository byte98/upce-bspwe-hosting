<?php

# 
# LOGGERSETTINGS.PHP
# File which contains definition of settings of logger.
#
# Author: Jiri Skoda<jiri.skoda@student.upce.cz>
#         Faculty of Electrical Engineering and Informatics
#         University of Pardubice
#         2024, Pardubice
#

namespace SimpleHosting\Utils\Logger;

use SimpleHosting\Utils\Logger\LogLevel;

/**
 * Class which contains settings of logger.
 */
class LoggerSettings{

    /**
     * Flag, whether application should create logs.
     */
    private readonly bool $log;

    /**
     * Path to directory to which logs will be created.
     */
    private readonly string $path;

    /**
     * Minimal level of logs which will be logged.
     */
    private readonly LogLevel $logLevel;

    /**
     * Flag, whether logs should be also printed to standard output.
     */
    private readonly bool $stdout;

    /**
     * Flag, whether standard output supports unicode.
     */
    private readonly bool $unicode;

    /**
     * Creates new settings of logger.
     * @param bool $log Flag, whether application should create logs.
     * @param string $path Path to directory to which logs will be created.
     * @param LogLevel $logLevel Minimal level of logs which will be logged.
     * @param bool $stdout Flag, whether logs should be also printed to standard output.
     * @param bool $unicode Flag, whether standard output supports unicode.
     */
    public function __construct(
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
     * @return bool TRUE, if application should create logs,
     *              FALSE otherwise.
     */
    public function getLog(): bool { return $this->log; }

    /**
     * Gets path to directory to which logs will be created.
     * @return string Path to directory to which logs will be created.
     */
    public function getLogPath(): string { return $this->path; }

    /**
     * Gets minimal level of logs which will be logged.
     * @return LogLevel Minimal level of logs which will be logged.
     */
    public function getLogLevel(): LogLevel { return $this->logLevel; }

    /**
     * Gets flag, whether logs should be also printed to standard output.
     * @return bool TRUE, if logs should be also printed to standard output,
     *              FALSE otherwise.
     */
    public function getStdout(): bool { return $this->stdout; }

    /**
     * Gets flag, whether standard output supports unicode.
     * @return bool TRUE, if standard output supports unicode,
     *              FALSE otherwise.
     */
    public function getUnicode(): bool { return $this->unicode; }
}

?>
