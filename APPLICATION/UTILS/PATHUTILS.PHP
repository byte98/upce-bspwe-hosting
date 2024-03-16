<?php

//
// PATHUTILS.PHP
// File containing some utilitites to work with route paths.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Utils;


use SimpleHosting\Router\PlaceholderType;

/**
 * Class which contains some utilities to work with route paths.
 */
class PathUtils{

    /**
     * Gets name of place holder from part of path.
     * @param string $pathPart Part of path.
     * @return string | false Name of place holder,
     *                        or FALSE if part contains no placeholder.
     */
    public static function getPlaceholderName(string $pathPart): string | false{
        $reti = false;
        if (PathUtils::isPlaceholder($pathPart)) {
            $colon_position = strpos($pathPart, ':');
            $reti = substr($pathPart, 1, $colon_position - 1);
        }
        return $reti;
    }

    /**
     * Gets data type of placeholder from part of path.
     * @param string $pathPart Part of path.
     * @return PlaceholderType | false Data type of placeholder,
     *                                or FALSE if part contains no placeholder
     *                                or if data type is invalid.
     */
    public static function getPlaceholderType(string $pathPart): false | PlaceholderType{
        $reti = false;
        if (PathUtils::isPlaceholder($pathPart)) { 
            $colon_position = strpos($pathPart, ':');
            $type = substr($pathPart, $colon_position + 2, -1);
            if ($type == "number"){
                $reti = PlaceholderType::Number;
            }
            else if ($type == "text"){
                $reti = PlaceholderType::Text;
            }
            else if ($type == "bool"){
                $reti = PlaceholderType::Boolean;
            }
        }
        return $reti;
    }

    /**
     * Checks, whether part of path contains placeholder.
     * @param string $pathPart Part of path which will be checked.
     * @return bool TRUE if part of path contains placeholder,
     *              FALSE otherwise.
     */
    public static function isPlaceholder(string $pathPart): bool{
        $reti = false;
        // Check if the part starts with '{' and ends with '}'
        if ($pathPart[0] === '{' && substr($pathPart, -1) === '}') {
            // Find the position of ':'
            $colon_position = strpos($pathPart, ':');
            
            // Check if ':' exists and if it's not at the beginning or end
            if ($colon_position !== false && $colon_position > 1 && $colon_position < strlen($pathPart) - 2) {
                $reti =  true; // Format is correct
            }
        }
        return $reti;
    }

    /**
     * Gets values from request.
     * @param string $route Original route.
     * @param string $request Requested url.
     * @return array Array with values from request.
     */
    public static function getValues(string $route, string $request): array{
        $parts = explode('/', $route);
        $data = explode('/', $request);
        $reti = array();
        for( $i = 0; $i < count($parts); $i++ ){
            if (PathUtils::isPlaceholder( $parts[$i] )) {
                $name = PathUtils::getPlaceholderName( $parts[$i] );
                $value = null;
                if (count($data) > $i){
                    $value = PathUtils::parseValue( $data[$i], PathUtils::getPlaceholderType( $parts[$i] ) );
                }
                $reti[$name] = $value;
            }
        }
        return $reti;
    }

    /**
     * Parses value from raw data to requested data type.
     * @param string $rawData Raw data which will be parsed.
     * @param PlaceholderType $requestedType Requested data type.
     * @return string | int | float | bool | null Parsed value,
     *                                            or NULL if data cannot be parsed.
     */
    private static function parseValue(string $rawData, PlaceholderType $requestedType): string | int | float | bool | null{
        $reti = null;
        if ($requestedType == PlaceholderType::Number && is_numeric($rawData)){
            $floatval = floatval($rawData);
            if (is_nan($floatval)){
                $intval = intval($rawData);
                if ($intval !== 0 || $rawData === '0'){
                    $reti = $intval;
                }
            }
            else{
                $reti = $floatval;
            }
        }
        else if ($requestedType == PlaceholderType::Boolean){
            $value = strtolower(StringUtils::trim($rawData));
            if ($value == "true"){
                $reti = true;
            }
            else if ($value == "false"){
                $reti = false;
            }
        }
        else if ($requestedType == PlaceholderType::Text){
            $reti = $rawData;
        }
        return $reti;
    }
}

?>
