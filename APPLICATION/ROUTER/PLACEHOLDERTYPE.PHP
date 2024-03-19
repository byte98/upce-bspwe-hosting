<?php

// PLACEHOLDERTYPE.PHP
// File containing all placeholder types.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Router;

/**
 * Enumeration of all available place holder types.
 */
enum PlaceholderType{
    /**
     * Placeholder is numeric data type.
     */
    case Number;

    /**
     * Placeholder is some kind of text.
     */
    case Text;

    /**
     * Placeholder is a boolean value.
     */
    case Boolean;

    /**
     * Checks, whether value matches this placeholder type.
     * @param mixed $value Value to check.
     * @return bool TRUE if value matches this placeholder type,
     *              FALSE otherwise.
     */
    public function valueMatches(mixed $value): bool{
        $reti = false;
        $valueType = gettype($value);
        if ($this == PlaceholderType::Number){
            if ($valueType == "integer" || $valueType == "double" || ($valueType == "string" && is_numeric($value))){
                $reti = true;
            }
        }
        else if ($this == PlaceholderType::Boolean){
            if ($valueType == "boolean" || ($valueType == "string" && (strtolower($value) == "true" || strtolower($value) == "false"))){
                $reti = true;
            }
        }
        else if ($this == PlaceholderType::Text){
            if ($valueType == "string"){
                $reti = true;
            }
        }
        return $reti;
    }
}

?>
