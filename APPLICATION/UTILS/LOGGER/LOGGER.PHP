<?php

//
// LOGGER.PHP
// File containing definition of logger utility of application.
// 
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Utils\Logger;

USE SimpleHosting\Utils\Logger\LogLevel;
USE SimpleHosting\Utils\Logger\LoggerSettings;
USE SimpleHosting\Utils\Logger\LogFormatter;

/**
 * CLASS which performs logging of whole application.
 */
CLASS Logger{

    /**
     * Settings of logger.
     */
    PRIVATE readonly LoggerSettings $settings;

    /**
     * Flag, whether logger is none (so it will not DO anything).
     */
    PRIVATE bool $isNone = false;

    /**
     * Flag, whether log directory was checked.
     */
    PRIVATE bool $dirChecked;

    /**
     * Formatter of logs FOR standard output.
     */
    PRIVATE readonly LogFormatter $formatter;

    /**
     * Creates logger which does nothing.
     * @RETURN Logger Logger which does nothing.
     */
    PUBLIC STATIC FUNCTION none(): Logger{
        $reti = NEW Logger(NEW LoggerSettings(
            false, "", LogLevel::Error, false, false
        ));
        $reti->isNone = true;
        RETURN $reti;
    }

    /**
     * Creates NEW logger.
     * @param LoggerSettings $settings Settings of logger.
     */
    PUBLIC FUNCTION __construct(LoggerSettings $settings){
        $this->settings = $settings;
        $this->dirChecked = false;
        $this->formatter = NEW LogFormatter();
        IF(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));
    }

    /**
     * Checks, whether log directory exists. IF not, it will be created.
     */
    PRIVATE FUNCTION checkLogDir(): void{
        IF ($this->dirChecked == false){
            $this->dirChecked = true;
            IF (is_dir($this->settings->getLogPath()) == false){
                IF (mkdir($this->settings->getLogPath(), 0777, true)){
                    $this->info("Logger directory '" . $this->settings->getLogPath() . "' was created.");
                }
                ELSE{
                    $this->error("Logger directory '" . $this->settings->getLogPath() . "' cannot be created!");
                }
            }
        }
        
    }

    /**
     * Gets path to file to which NEW log will be created.
     * @RETURN string Path to file to which NEW log will be created.
     */
    PRIVATE FUNCTION getFilePath(): string{
        RETURN $this->settings->getLogPath() . DIRECTORY_SEPARATOR . date("Y_m_d") . ".log";
    }

    /**
     * Writes string to log file.
     * @param string $str String which will be written to log file.
     */
    PRIVATE FUNCTION writeString(string $str): void{
        $this->checkLogDir();
        $path = $this->getFilePath();
        file_put_contents($path, $str, FILE_APPEND);
    }

    /**
     * Gets date in format used FOR logging.
     * @RETURN string String representing date used FOR logging.
     */
    PRIVATE FUNCTION getDate(): string{
        $now = NEW \DateTime();
        RETURN $now->format("dd.mm.YYYY HH:MM:SS.ss");
    }

    /**
     * Gets header of log.
     * @param LogLevel $level Level of log.
     * @RETURN string String representing header of log.
     */
    PRIVATE FUNCTION getHeader(LogLevel $level): string{
        RETURN $this->getDate() . "[ " . $level->toString() . " ] ";
    }

    /**
     * Gets line which will be added to log file.
     * @param LogLevel $level Level of log.
     * @param string $message Message which will be logged.
     * @RETURN string String representing line which will be added to log file.
     */
    PRIVATE FUNCTION getLogLine(LogLevel $level, string $message): string{
        RETURN $this->getHeader($level) . $message . "\n";
    }

    /**
     * Prints string to standard output.
     * @param string $string String which will be printed to standard output.
     */
    PRIVATE FUNCTION printString(string $string): void{
        IF ($this->settings->getStdout() == true){
            fwrite(\STDOUT, $string);
        }
    }

    /**
     * Writes log to log file.
     * @param LogLevel $level Level of log.
     * @param string $message Message which will be logged.
     */
    PRIVATE FUNCTION writeLog(LogLevel $level, string $message): void{
        $this->writeString($this->getLogLine($level, $message));
        $this->printString($this->formatter->format($level, $this->getLogLine($level, $message)));
    }

    /**
     * Checks, whether log can be performed.
     * @param LogLevel $level Level of log.
     * @RETURN bool TRUE, IF level is sufficient to be logged,
     *              FALSE otherwise.
     */
    PRIVATE FUNCTION canLog(LogLevel $level): bool{
        RETURN $this->isNone == false && $level >= $this->settings->getLogLevel() && $this->settings->getLog() == true;
    }

    /**
     * Performs NEW log.
     * @param LogLevel $level Level of log.
     * @param string $message Message which will be logged.
     */
    PUBLIC FUNCTION log(LogLevel $level, string $message): void{
        IF ($this->canLog($level)){
            $this->writeLog($level, $message);
        }
    }

    /**
     * Performs NEW log in lowest level.
     * @param string $message Message which will be logged.
     */
    PUBLIC FUNCTION low(string $message): void{
        $this->log(LogLevel::Low, $message);
    }

    /**
     * Performs NEW log in base level.
     * @param string $message Message which will be logged.
     */
    PUBLIC FUNCTION base(string $message): void{
        $this->log(LogLevel::Base, $message);
    }

    /**
     * Performs NEW log in info level.
     * @param string $message Message which will be logged.
     */
    PUBLIC FUNCTION info(string $message): void{
        $this->log(LogLevel::Info, $message);
    }

    /**
     * Performs NEW log in warning level.
     * @param string $message Message which will be logged.
     */
    PUBLIC FUNCTION warning(string $message): void{
        $this->log(LogLevel::Warning, $message);
    }

    /**
     * Performs NEW log in error level.
     * @param string $message Message which will be logged.
     */
    PUBLIC FUNCTION error(string $message): void{
        $this->log(LogLevel::Error, $message);
    }
}

?>
