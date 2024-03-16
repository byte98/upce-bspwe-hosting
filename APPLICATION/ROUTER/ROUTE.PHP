<?php

//
// ROUTE.PHP
// File containing definition of single route of application.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Router;

use SimpleHosting\Controller\Controller;
use SimpleHosting\Utils\PathUtils;

/**
 * Class representing single route of application.
 */
class Route{

    /**
     * Path of application.
     */
    private string $path;

    /**
     * Target of route.
     */
    private Controller $target;

    /**
     * Creates new route.
     * @param string $path Path of application
     * @param Controller $target Target of route.
     */
    public function __construct(string $path, Controller $target){
        $this->path = $path;
        $this->target = $target;
    }

    /**
     * Checks, whether path matches route.
     * @param string $path Path of application.
     * @return bool TRUE if path matches route,
     *              FALSE otherwise.
     */
    public function matches(string $path): bool{
        $reti = false;
        $parts = explode("/", $path);
        $rparts = explode("/", $this->path);
        if (count($parts) == count($rparts)){
            $reti = true;
            for($i = 0; $i < count($parts); $i++){
                $part = $parts[$i];
                $rpart = $rparts[$i];
                if (PathUtils::isPlaceholder($rpart)){ 
                    // In route definititon, there is placeholder.
                    // So, type is parsed from definition and then
                    // checked against actual value in path.
                    $ptype = PathUtils::getPlaceholderType($rpart);
                    if ($ptype !== false){
                        $reti = $ptype->valueMatches($part);
                        if ($reti == false){
                            break;
                        }
                    }
                    else{
                        Application::logger()->error("Cannot get type of placeholder '" . $rpart . "' (path: " . $this->path . ")");
                        $reti = false;
                        break;
                    }
                }
                else{
                    // There is no placeholder; just check strings.
                    $reti = ($part == $rpart);
                    if ($reti == false){
                        break;
                    }
                }
            }
        }
        return $reti;
    }

    /**
     * Checks, whether path is equal to path of route.
     * @param string $path Path which will be checked.
     * @return bool TRUE if path is equal to path of route,
     *              FALSE otherwise.
     */
    public function equals(string $path): bool{
        return $this->path == $path;
    }

    /**
     * Gets target of route.
     * @return Controller Controller which is target of route.
     */
    public function getTarget(): Controller{
        return $this->target;
    }

    /**
     * Gets data from request.
     * @param string $request Requested url.
     */
    public function getData(string $request): array{
        return PathUtils::getValues($this->path, $request);
    }
}

?>
