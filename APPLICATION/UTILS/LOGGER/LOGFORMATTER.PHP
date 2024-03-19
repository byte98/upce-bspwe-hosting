<?php

//
// LOGFORMATTER.PHP
// File containing definition of utility used for formatting of logs.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Utils\Logger;

/**
 * Class which provides utilities to format logs for standard output.
 */
class LogFormatter{

    /**
     * Definitions of colors according to log levels.
     */
    private readonly array $colors; 

    /**
     * Definitions of symbols according to log levels.
     */
    private readonly array $symbols;

    /**
     * Creates new formatter of logs for standard output.
     */
    public function __construct(){
        $this->colors = [
            LogLevel::Low->toString() => LogFormatColor::BlackBright->toString(),
            LogLevel::Base->toString() => LogFormatColor::WhiteBright->toString(),
            LogLevel::Info->toString() => LogFormatColor::BlueBright->toString(),
            LogLevel::Warning->toString() => LogFormatColor::YellowBright->toString(),
            LogLevel::Error->toString() => LogFormatColor::RedBright->toString(),
            LogLevel::Critical->toString() => LogFormatColor::RedBright->toString()
        ];
        $this->symbols = [
            LogLevel::Low->toString() => " ",
            LogLevel::Base->toString() => " ",
            LogLevel::Info->toString() => "ℹ️",
            LogLevel::Warning->toString() => "⚠️",
            LogLevel::Error->toString() => "🛑",
            LogLevel::Critical->toString() => "📛"
        ];

    }

    /**
     * Formats log for standard output.
     * @param LogLevel $level Level of log.
     * @param string $line Line representing whole log which should be printed out.
     * @return string Formatted line which can be printed out.
     */
    public function format(LogLevel $level, string $line): string{
        return
            $this->colors[$level->toString()] .
            $this->symbols[$level->toString()] .
            " " .
            $line .
            LogFormatColor::Reset->toString() .
            "\n";
    }
}

?>
