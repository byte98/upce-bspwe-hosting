<?php

//
// PATHUTILS.PHP
// File containing some utilitites to work with route paths.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Utils;


USE SimpleHosting\Router\PlaceholderType;

/**
 * CLASS which contains some utilities to work with route paths.
 */
CLASS PathUtils{

    /**
     * Gets name of place holder from part of path.
     * @param string $pathPart Part of path.
     * @RETURN string | false Name of place holder,
     *                        OR FALSE IF part contains no placeholder.
     */
    PUBLIC STATIC FUNCTION getPlaceholderName(string $pathPart): string | false{
        $reti = false;
        IF (PathUtils::isPlaceholder($pathPart)) {
            $colon_position = strpos($pathPart, ':');
            $reti = substr($pathPart, 1, $colon_position - 1);
        }
        RETURN $reti;
    }

    /**
     * Gets data type of placeholder from part of path.
     * @param string $pathPart Part of path.
     * @RETURN PlaceholderType | false Data type of placeholder,
     *                                OR FALSE IF part contains no placeholder
     *                                OR IF data type is invalid.
     */
    PUBLIC STATIC FUNCTION getPlaceholderType(string $pathPart): false | PlaceholderType{
        $reti = false;
        IF (PathUtils::isPlaceholder($pathPart)) { 
            $colon_position = strpos($pathPart, ':');
            $type = substr($pathPart, $colon_position + 2, -1);
            IF ($type == "number"){
                $reti = PlaceholderType::Number;
            }
            ELSE IF ($type == "text"){
                $reti = PlaceholderType::Text;
            }
            ELSE IF ($type == "bool"){
                $reti = PlaceholderType::Boolean;
            }
        }
        RETURN $reti;
    }

    /**
     * Checks, whether part of path contains placeholder.
     * @param string $pathPart Part of path which will be checked.
     * @RETURN bool TRUE IF part of path contains placeholder,
     *              FALSE otherwise.
     */
    PUBLIC STATIC FUNCTION isPlaceholder(string $pathPart): bool{
        $reti = false;
        // Check IF the part starts with '{' AND ends with '}'
        IF ($pathPart[0] === '{' && substr($pathPart, -1) === '}') {
            // Find the position of ':'
            $colon_position = strpos($pathPart, ':');
            
            // Check IF ':' exists AND IF it's not at the beginning OR end
            IF ($colon_position !== false && $colon_position > 1 && $colon_position < strlen($pathPart) - 2) {
                $reti =  true; // Format is correct
            }
        }
        RETURN $reti;
    }

    /**
     * Gets values from request.
     * @param string $route Original route.
     * @param string $request Requested url.
     * @RETURN ARRAY ARRAY with values from request.
     */
    PUBLIC STATIC FUNCTION getValues(string $route, string $request): ARRAY{
        $parts = explode('/', $route);
        $data = explode('/', $request);
        $reti = ARRAY();
        FOR( $i = 0; $i < count($parts); $i++ ){
            IF (PathUtils::isPlaceholder( $parts[$i] )) {
                $name = PathUtils::getPlaceholderName( $parts[$i] );
                $value = null;
                IF (count($data) > $i){
                    $value = PathUtils::parseValue( $data[$i], PathUtils::getPlaceholderType( $parts[$i] ) );
                }
                $reti[$name] = $value;
            }
        }
        RETURN $reti;
    }

    /**
     * Parses value from raw data to requested data type.
     * @param string $rawData Raw data which will be parsed.
     * @param PlaceholderType $requestedType Requested data type.
     * @RETURN string | int | float | bool | null Parsed value,
     *                                            OR NULL IF data cannot be parsed.
     */
    PRIVATE STATIC FUNCTION parseValue(string $rawData, PlaceholderType $requestedType): string | int | float | bool | null{
        $reti = null;
        IF ($requestedType == PlaceholderType::Number && is_numeric($rawData)){
            $floatval = floatval($rawData);
            IF (is_nan($floatval)){
                $intval = intval($rawData);
                IF ($intval !== 0 || $rawData === '0'){
                    $reti = $intval;
                }
            }
            ELSE{
                $reti = $floatval;
            }
        }
        ELSE IF ($requestedType == PlaceholderType::Boolean){
            $value = strtolower(StringUtils::trim($rawData));
            IF ($value == "true"){
                $reti = true;
            }
            ELSE IF ($value == "false"){
                $reti = false;
            }
        }
        ELSE IF ($requestedType == PlaceholderType::Text){
            $reti = $rawData;
        }
        RETURN $reti;
    }
}

?>
