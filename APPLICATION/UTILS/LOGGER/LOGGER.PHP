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

namespace SimpleHosting\Utils\Logger;

use SimpleHosting\Utils\Logger\LogLevel;
use SimpleHosting\Utils\Logger\LoggerSettings;
use SimpleHosting\Utils\Logger\LogFormatter;

/**
 * Class which performs logging of whole application.
 */
class Logger{

    /**
     * Settings of logger.
     */
    private readonly LoggerSettings $settings;

    /**
     * Flag, whether logger is none (so it will not do anything).
     */
    private bool $isNone = false;

    /**
     * Flag, whether log directory was checked.
     */
    private bool $dirChecked;

    /**
     * Formatter of logs for standard output.
     */
    private readonly LogFormatter $formatter;

    /**
     * Creates logger which does nothing.
     * @return Logger Logger which does nothing.
     */
    public static function none(): Logger{
        $reti = new Logger(new LoggerSettings(
            false, "", LogLevel::Error, false, false
        ));
        $reti->isNone = true;
        return $reti;
    }

    /**
     * Creates new logger.
     * @param LoggerSettings $settings Settings of logger.
     */
    public function __construct(LoggerSettings $settings){
        $this->settings = $settings;
        $this->dirChecked = false;
        $this->formatter = new LogFormatter();
        if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));
    }

    /**
     * Checks, whether log directory exists. If not, it will be created.
     */
    private function checkLogDir(): void{
        if ($this->dirChecked == false){
            $this->dirChecked = true;
            if (is_dir($this->settings->getLogPath()) == false){
                if (mkdir($this->settings->getLogPath(), 0777, true)){
                    $this->info("Logger directory '" . $this->settings->getLogPath() . "' was created.");
                }
                else{
                    $this->error("Logger directory '" . $this->settings->getLogPath() . "' cannot be created!");
                }
            }
        }
        
    }

    /**
     * Gets path to file to which new log will be created.
     * @return string Path to file to which new log will be created.
     */
    private function getFilePath(): string{
        return $this->settings->getLogPath() . DIRECTORY_SEPARATOR . date("Y_m_d") . ".log";
    }

    /**
     * Writes string to log file.
     * @param string $str String which will be written to log file.
     */
    private function writeString(string $str): void{
        $this->checkLogDir();
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
     * Prints string to standard output.
     * @param string $string String which will be printed to standard output.
     */
    private function printString(string $string): void{
        if ($this->settings->getStdout() == true){
            fwrite(\STDOUT, $string);
        }
    }

    /**
     * Writes log to log file.
     * @param LogLevel $level Level of log.
     * @param string $message Message which will be logged.
     */
    private function writeLog(LogLevel $level, string $message): void{
        $this->writeString($this->getLogLine($level, $message));
        $this->printString($this->formatter->format($level, $this->getLogLine($level, $message)));
    }

    /**
     * Checks, whether log can be performed.
     * @param LogLevel $level Level of log.
     * @return bool TRUE, if level is sufficient to be logged,
     *              FALSE otherwise.
     */
    private function canLog(LogLevel $level): bool{
        return $this->isNone == false && $level >= $this->settings->getLogLevel() && $this->settings->getLog() == true;
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
        if ($level == LogLevel::Critical){
            exit($message);
        }
    }

    /**
     * Performs new log in lowest level.
     * @param string $message Message which will be logged.
     */
    public function low(string $message): void{
        $this->log(LogLevel::Low, $message);
    }

    /**
     * Performs new log in base level.
     * @param string $message Message which will be logged.
     */
    public function base(string $message): void{
        $this->log(LogLevel::Base, $message);
    }

    /**
     * Performs new log in info level.
     * @param string $message Message which will be logged.
     */
    public function info(string $message): void{
        $this->log(LogLevel::Info, $message);
    }

    /**
     * Performs new log in warning level.
     * @param string $message Message which will be logged.
     */
    public function warning(string $message): void{
        $this->log(LogLevel::Warning, $message);
    }

    /**
     * Performs new log in error level.
     * @param string $message Message which will be logged.
     */
    public function error(string $message): void{
        $this->log(LogLevel::Error, $message);
    }

    /**
     * Performs new log in critical level and then exits program.
     * @param string $message Message which will be logged.
     */
    public function critical(string $message): void{
        $this->log(LogLevel::Critical, $message);
    }
}

?>
