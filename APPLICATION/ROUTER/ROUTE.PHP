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
     * Computes match of path to route.
     * @param string $path Path of application.
     * @return float Percentage of match of path to route.
     */
    public function matches(string $path): float{
        $reti = 1.0;
        $parts = explode("/", $path);
        $myParts = explode("/", $this->path);
        $partWeight = 1.0 / (float)count($parts);
        foreach($parts as $part){
            
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
}

?>
