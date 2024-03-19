<?php

//
// STRINGUTILS.PHP
// File containing utilities to work with strings.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Utils;

/**
 * CLASS which holds some utility functions to work with strings.
 */
CLASS StringUtils{

    /**
     * Trims string out of white space characters.
     * @param string $string String which will be trimmed.
     * @RETURN string String without white space characters.
     */
    PUBLIC STATIC FUNCTION trim(string $string): string{
        RETURN preg_replace('/\s+/', '', $string);
    }
}

?>
