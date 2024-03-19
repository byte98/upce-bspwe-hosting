<?php

//
// ROUTE.PHP
// File containing definition of single route of application.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Router;

USE SimpleHosting\Controller\Controller;
USE SimpleHosting\Utils\PathUtils;

/**
 * CLASS representing single route of application.
 */
CLASS Route{

    /**
     * Path of application.
     */
    PRIVATE string $path;

    /**
     * Target of route.
     */
    PRIVATE Controller $target;

    /**
     * Creates NEW route.
     * @param string $path Path of application
     * @param Controller $target Target of route.
     */
    PUBLIC FUNCTION __construct(string $path, Controller $target){
        $this->path = $path;
        $this->target = $target;
    }

    /**
     * Checks, whether path matches route.
     * @param string $path Path of application.
     * @RETURN bool TRUE IF path matches route,
     *              FALSE otherwise.
     */
    PUBLIC FUNCTION matches(string $path): bool{
        $reti = false;
        $parts = explode("/", $path);
        $rparts = explode("/", $this->path);
        IF (count($parts) == count($rparts)){
            $reti = true;
            FOR($i = 0; $i < count($parts); $i++){
                $part = $parts[$i];
                $rpart = $rparts[$i];
                IF (PathUtils::isPlaceholder($rpart)){ 
                    // In route definititon, there is placeholder.
                    // So, type is parsed from definition AND then
                    // checked against actual value in path.
                    $ptype = PathUtils::getPlaceholderType($rpart);
                    IF ($ptype !== false){
                        $reti = $ptype->valueMatches($part);
                        IF ($reti == false){
                            BREAK;
                        }
                    }
                    ELSE{
                        Application::logger()->error("Cannot get type of placeholder '" . $rpart . "' (path: " . $this->path . ")");
                        $reti = false;
                        BREAK;
                    }
                }
                ELSE{
                    // There is no placeholder; just check strings.
                    $reti = ($part == $rpart);
                    IF ($reti == false){
                        BREAK;
                    }
                }
            }
        }
        RETURN $reti;
    }

    /**
     * Checks, whether path is equal to path of route.
     * @param string $path Path which will be checked.
     * @RETURN bool TRUE IF path is equal to path of route,
     *              FALSE otherwise.
     */
    PUBLIC FUNCTION equals(string $path): bool{
        RETURN $this->path == $path;
    }

    /**
     * Gets target of route.
     * @RETURN Controller Controller which is target of route.
     */
    PUBLIC FUNCTION getTarget(): Controller{
        RETURN $this->target;
    }

    /**
     * Gets data from request.
     * @param string $request Requested url.
     */
    PUBLIC FUNCTION getData(string $request): ARRAY{
        RETURN PathUtils::getValues($this->path, $request);
    }

    /**
     * Gets length of path of route.
     * @RETURN int Integer representing length of route.
     */
    PUBLIC FUNCTION getLength(): int{
        RETURN strlen($this->path);
    }
}

?>
