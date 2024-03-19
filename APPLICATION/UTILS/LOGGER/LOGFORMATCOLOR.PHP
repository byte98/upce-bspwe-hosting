<?php

// 
// LOGFORMATCOLOR.PHP
// File containing color definitions FOR logs.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Utils\Logger;

/**
 * Enumeration of all available colors FOR standard output.
 */
enum LogFormatColor{

    /**
     * Black foreground color.
     */
    CASE Black;
    
    /**
     * Red foreground color.
     */
    CASE Red;

    /**
     * Green foreground color.
     */
    CASE Green;

    /**
     * Yellow foreground color.
     */
    CASE Yellow;

    /**
     * Blue foreground color.
     */
    CASE Blue;

    /**
     * Magenta foreground color.
     */
    CASE Magenta;

    /**
     * Cyan foreground color.
     */
    CASE Cyan;

    /**
     * White (more like gray) foreground color.
     */
    CASE White;

    /**
     * Bright black (gray) foreground color.
     */
    CASE BlackBright;

    /**
     * Bright red foreground color.
     */
    CASE RedBright;

    /**
     * Bright green foreground color.
     */
    CASE GreenBright;

    /**
     * Bright yellow foreground color.
     */
    CASE YellowBright;

    /**
     * Bright blue foreground color.
     */
    CASE BlueBright;

    /**
     * Bright magenta foreground color.
     */
    CASE MagentaBright;

    /**
     * Bright cyan foreground color.
     */
    CASE CyanBright;

    /**
     * Bright white foreground color.
     */
    CASE WhiteBright;

    /**
     * Resets color to system defaults.
     */
    CASE Reset;

    /**
     * Escape character.
     */
    PRIVATE CONST ESCAPE = "\x1B";

    /**
     * Gets string representation of color ready to be printed.
     */
    PUBLIC FUNCTION toString(): string{
        $reti = LogFormatColor::ESCAPE;
        $suffix = "[0m;";
        SWITCH($this){
            CASE LogFormatColor::Black:   $suffix = "[;30m"; BREAK;
            CASE LogFormatColor::Red:     $suffix = "[;31m"; BREAK;
            CASE LogFormatColor::Green:   $suffix = "[;32m"; BREAK;
            CASE LogFormatColor::Yellow:  $suffix = "[;33m"; BREAK;
            CASE LogFormatColor::Blue:    $suffix = "[;34m"; BREAK;
            CASE LogFormatColor::Magenta: $suffix = "[;35m"; BREAK;
            CASE LogFormatColor::Cyan:    $suffix = "[;36m"; BREAK;
            CASE LogFormatColor::White:   $suffix = "[;37m"; BREAK;

            CASE LogFormatColor::BlackBright:   $suffix = "[;90m"; BREAK;
            CASE LogFormatColor::RedBright:     $suffix = "[;91m"; BREAK;
            CASE LogFormatColor::GreenBright:   $suffix = "[;92m"; BREAK;
            CASE LogFormatColor::YellowBright:  $suffix = "[;93m"; BREAK;
            CASE LogFormatColor::BlueBright:    $suffix = "[;94m"; BREAK;
            CASE LogFormatColor::MagentaBright: $suffix = "[;95m"; BREAK;
            CASE LogFormatColor::CyanBright:    $suffix = "[;96m"; BREAK;
            CASE LogFormatColor::WhiteBright:   $suffix = "[;97m"; BREAK;

            CASE LogFormatColor::Reset: $suffix = "[0m"; BREAK;
        }
        RETURN $reti . $suffix;
    }
}

?>
