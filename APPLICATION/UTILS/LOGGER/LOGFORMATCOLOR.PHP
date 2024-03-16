<?php

// 
// LOGFORMATCOLOR.PHP
// File containing color definitions for logs.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Utils\Logger;

/**
 * Enumeration of all available colors for standard output.
 */
enum LogFormatColor{

    /**
     * Black foreground color.
     */
    case Black;
    
    /**
     * Red foreground color.
     */
    case Red;

    /**
     * Green foreground color.
     */
    case Green;

    /**
     * Yellow foreground color.
     */
    case Yellow;

    /**
     * Blue foreground color.
     */
    case Blue;

    /**
     * Magenta foreground color.
     */
    case Magenta;

    /**
     * Cyan foreground color.
     */
    case Cyan;

    /**
     * White (more like gray) foreground color.
     */
    case White;

    /**
     * Bright black (gray) foreground color.
     */
    case BlackBright;

    /**
     * Bright red foreground color.
     */
    case RedBright;

    /**
     * Bright green foreground color.
     */
    case GreenBright;

    /**
     * Bright yellow foreground color.
     */
    case YellowBright;

    /**
     * Bright blue foreground color.
     */
    case BlueBright;

    /**
     * Bright magenta foreground color.
     */
    case MagentaBright;

    /**
     * Bright cyan foreground color.
     */
    case CyanBright;

    /**
     * Bright white foreground color.
     */
    case WhiteBright;

    /**
     * Resets color to system defaults.
     */
    case Reset;

    /**
     * Escape character.
     */
    private const ESCAPE = "\x1B";

    /**
     * Gets string representation of color ready to be printed.
     */
    public function toString(): string{
        $reti = LogFormatColor::ESCAPE;
        $suffix = "[0m;";
        switch($this){
            case LogFormatColor::Black:   $suffix = "[;30m"; break;
            case LogFormatColor::Red:     $suffix = "[;31m"; break;
            case LogFormatColor::Green:   $suffix = "[;32m"; break;
            case LogFormatColor::Yellow:  $suffix = "[;33m"; break;
            case LogFormatColor::Blue:    $suffix = "[;34m"; break;
            case LogFormatColor::Magenta: $suffix = "[;35m"; break;
            case LogFormatColor::Cyan:    $suffix = "[;36m"; break;
            case LogFormatColor::White:   $suffix = "[;37m"; break;

            case LogFormatColor::BlackBright:   $suffix = "[;90m"; break;
            case LogFormatColor::RedBright:     $suffix = "[;91m"; break;
            case LogFormatColor::GreenBright:   $suffix = "[;92m"; break;
            case LogFormatColor::YellowBright:  $suffix = "[;93m"; break;
            case LogFormatColor::BlueBright:    $suffix = "[;94m"; break;
            case LogFormatColor::MagentaBright: $suffix = "[;95m"; break;
            case LogFormatColor::CyanBright:    $suffix = "[;96m"; break;
            case LogFormatColor::WhiteBright:   $suffix = "[;97m"; break;

            case LogFormatColor::Reset: $suffix = "[0m"; break;
        }
        return $reti . $suffix;
    }
}

?>
