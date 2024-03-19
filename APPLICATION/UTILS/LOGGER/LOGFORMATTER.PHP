<?php

//
// LOGFORMATTER.PHP
// File containing definition of utility used FOR formatting of logs.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Utils\Logger;

/**
 * CLASS which provides utilities to format logs FOR standard output.
 */
CLASS LogFormatter{

    /**
     * Definitions of colors according to log levels.
     */
    PRIVATE readonly ARRAY $colors; 

    /**
     * Definitions of symbols according to log levels.
     */
    PRIVATE readonly ARRAY $symbols;

    /**
     * Creates NEW formatter of logs FOR standard output.
     */
    PUBLIC FUNCTION __construct(){
        $this->colors = [
            LogLevel::Low->toString() => LogFormatColor::BlackBright->toString(),
            LogLevel::Base->toString() => LogFormatColor::WhiteBright->toString(),
            LogLevel::Info->toString() => LogFormatColor::BlueBright->toString(),
            LogLevel::Warning->toString() => LogFormatColor::YellowBright->toString(),
            LogLevel::Error->toString() => LogFormatColor::RedBright->toString()
        ];
        $this->symbols = [
            LogLevel::Low->toString() => " ",
            LogLevel::Base->toString() => " ",
            LogLevel::Info->toString() => "ℹ️",
            LogLevel::Warning->toString() => "⚠️",
            LogLevel::Error->toString() => "🛑"
        ];

    }

    /**
     * Formats log FOR standard output.
     * @param LogLevel $level Level of log.
     * @param string $line Line representing whole log which should be printed out.
     * @RETURN string Formatted line which can be printed out.
     */
    PUBLIC FUNCTION format(LogLevel $level, string $line): string{
        RETURN
            $this->colors[$level->toString()] .
            $this->symbols[$level->toString()] .
            " " .
            $line .
            LogFormatColor::Reset->toString() .
            "\n";
    }
}

?>
