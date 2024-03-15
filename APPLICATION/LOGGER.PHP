<?php

//
// LOGGER.PHP
// File containing definition of logger utility of application.
// 
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting;

use SimpleHosting\LogLevel;

/**
 * Class which performs logging of whole application.
 */
class Logger{

    /**
     * Minimal level of logs which will be logged.
     */
    private LogLevel $level;

    /**
     * Path to directory to which logs will be saved.
     */
    private string $path;

    /**
     * Flag, whether logger is none (so it will not do anything).
     */
    private bool $isNone = false;

    /**
     * Creates logger which does nothing.
     * @return Logger Logger which does nothing.
     */
    public static function none(): Logger{
        $reti = new Logger(LogLevel::ERROR, "");
        $reti->isNone = true;
        return $reti;
    }

    /**
     * Creates new logger.
     * @param LogLevel $level Minimal level of log which will be logged.
     * @param string $path Path to directory where logs will be created.
     */
    public function __construct(LogLevel $level, string $path){
        $this->level = $level;
        $this->path = $path;
    }

    /**
     * Gets path to file to which new log will be created.
     * @return string Path to file to which new log will be created.
     */
    private function getFilePath(): string{
        return $this->path . DIRECTORY_SEPARATOR . date("Y_m_d") . ".log";
    }

    /**
     * Writes string to log file.
     * @param string $str String which will be written to log file.
     */
    private function writeString(string $str): void{
        $path = $this->getFilePath();
        file_put_contents($path, $str, FILE_APPEND);
    }

    /**
     * Gets date in format used for logging.
     * @return string String representing date used for logging.
     */
    private function getDate(): string{
        $now = new \DateTime();
        return $now->format("dd.mm.YYYY HH:MM:SS.ss");
    }

    /**
     * Gets header of log.
     * @param LogLevel $level Level of log.
     * @return string String representing header of log.
     */
    private function getHeader(LogLevel $level): string{
        return $this->getDate() . "[ " . $level->toString() . " ] ";
    }

    /**
     * Gets line which will be added to log file.
     * @param LogLevel $level Level of log.
     * @param string $message Message which will be logged.
     * @return string String representing line which will be added to log file.
     */
    private function getLogLine(LogLevel $level, string $message): string{
        return $this->getHeader($level) . $message . "\n";
    }

    /**
     * Writes log to log file.
     * @param LogLevel $level Level of log.
     * @param string $message Message which will be logged.
     */
    private function writeLog(LogLevel $level, string $message): void{
        $this->writeString($this->getLogLine($level, $message));
    }

    /**
     * Checks, whether log can be performed.
     * @param LogLevel $level Level of log.
     * @return bool TRUE, if level is sufficient to be logged,
     *              FALSE otherwise.
     */
    private function canLog(LogLevel $level): bool{
        return $this->isNone == false && $level >= $this->level;
    }

    /**
     * Performs new log.
     * @param LogLevel $level Level of log.
     * @param string $message Message which will be logged.
     */
    public function log(LogLevel $level, string $message): void{
        if ($this->canLog($level)){
            $this->writeLog($level, $message);
        }
    }

    /**
     * Performs new log in base level.
     * @param string $message Message which will be logged.
     */
    public function base(string $message): void{
        $this->log(LogLevel::BASE, $message);
    }

    /**
     * Performs new log in info level.
     * @param string $message Message which will be logged.
     */
    public function info(string $message): void{
        $this->log(LogLevel::INFO, $message);
    }

    /**
     * Performs new log in warning level.
     * @param string $message Message which will be logged.
     */
    public function warning(string $message): void{
        $this->log(LogLevel::WARNING, $message);
    }

    /**
     * Performs new log in error level.
     * @param string $message Message which will be logged.
     */
    public function error(string $message): void{
        $this->log(LogLevel::ERROR, $message);
    }
}

?>
