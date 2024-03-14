<?php

//
// ROUTER.PHP
// File containing definition of application router.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Router;

use SimpleHosting\Application;
use SimpleHosting\Controller\Controller;

/**
 * Class representing router of application.
 */
class Router{

    /**
     * Array with all available routes.
     */
    private array $routes;

    /**
     * Creates new router.
     * @param array $routes Array with routes managed by router.
     */
    public function __construct(array $routes){
        $this->routes = $routes;
    }

    /**
     * Performs routing.
     * @param string $path Path of application.
     * @return Controller Target of route,
     *                    or NULL if routing table is empty.
     */
    public function route(string $path): ?Controller{
        $reti = NULL;
        if (count($this->routes) > 0){
            $reti = $this->routes[0];
            $match = $reti->matches($path);
            foreach($this->routes as $route){
                if ($route->matches($path) > $match){
                    $reti = $route;
                    $match = $reti->matches($path);
                }
            }
        }
        else{
            Application::logger()->error("Routing table is empty!");
        }
        return $reti;
    }
}

?>
