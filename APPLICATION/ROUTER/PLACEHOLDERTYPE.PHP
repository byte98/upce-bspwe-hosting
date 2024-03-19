<?php

// PLACEHOLDERTYPE.PHP
// File containing all placeholder types.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Router;

/**
 * Enumeration of all available place holder types.
 */
enum PlaceholderType{
    /**
     * Placeholder is numeric data type.
     */
    CASE Number;

    /**
     * Placeholder is some kind of text.
     */
    CASE Text;

    /**
     * Placeholder is a boolean value.
     */
    CASE Boolean;

    /**
     * Checks, whether value matches this placeholder type.
     * @param mixed $value Value to check.
     * @RETURN bool TRUE IF value matches this placeholder type,
     *              FALSE otherwise.
     */
    PUBLIC FUNCTION valueMatches(mixed $value): bool{
        $reti = false;
        $valueType = gettype($value);
        IF ($this == PlaceholderType::Number){
            IF ($valueType == "integer" || $valueType == "double" || ($valueType == "string" && is_numeric($value))){
                $reti = true;
            }
        }
        ELSE IF ($this == PlaceholderType::Boolean){
            IF ($valueType == "boolean" || ($valueType == "string" && (strtolower($value) == "true" || strtolower($value) == "false"))){
                $reti = true;
            }
        }
        ELSE IF ($this == PlaceholderType::Text){
            IF ($valueType == "string"){
                $reti = true;
            }
        }
        RETURN $reti;
    }
}

?>
