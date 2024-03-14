<?php

//
// STRINGUTILS.PHP
// File containing utilities to work with strings.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Utils;

/**
 * Class which holds some utility functions to work with strings.
 */
class StringUtils{

    /**
     * Trims string out of white space characters.
     * @param string $string String which will be trimmed.
     * @return string String without white space characters.
     */
    public static function trim(string $string): string{
        return preg_replace('/\s+/', '', $string);
    }
}

?>
