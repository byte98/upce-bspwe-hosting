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

use SimpleHosting\Router\Route;
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
     */
    public function __construct(){
        $this->routes = array();
    }

    /**
     * Adds route to router.
     * @param string $path Path of route.
     * @param Controller $controller Controller of route.
     */
    public function addRoute(string $path, Controller $controller){
        if ($this->containsRoute($path) == false){
            array_push($this->routes, new Route($path, $controller));
            Application::logger()->info("New route added (" . $path . " ->  " . get_class($controller) . ")");
        }
        else{
            Application::logger()->warning("Cannot add route: route already exists (" . $path . " ->  " . get_class($controller) . " is already routed to " . $this->getExactRouteName($path) . ")");
        }
    }

    /**
     * Checks, whether routing table already contains route with path.
     * @param string $path Path of route.
     * @return bool TRUE if route is in routing table,
     *              FALSE otherwise.
     */
    private function containsRoute(string $path){
        $reti = false;
        foreach($this->routes as $route){
            if ($route->equals($path)){
                $reti = true;
                break;
            }
        }
        return $reti;
    }

    /**
     * Gets name of controller of route.
     * @param string $path Path of route.
     * @return string Name of controller of route.
     */
    private function getExactRouteName(string $path): string{
        $reti = "<unknown>";
        foreach($this->routes as $route){
            if ($route->equals($path)){
                $reti = get_class($route->getTarget());
                break;
            }
        }
        return $reti;
    }

    /**
     * Performs routing.
     * @param string $path Path of application.
     * @return Route Route to which request should be routed,
     *                or NULL if no such route can be found.
     */
    public function route(string $path): ?Route{
        $reti = NULL;
        if (count($this->routes) > 0){
            $route = $this->getRoute($path);
            if ($route != null){
                $reti = $route;
            }
            else{
                Application::logger()->warning("Cannot find controller for path '" . $path . "'");
            }
        }
        else{
            Application::logger()->error("Routing table is empty!");
        }
        return $reti;
    }

    /**
     * Gets route associated with application path.
     * @param string $path Path of application.
     * @return Route Route associated with application path,
     *                or NULL if no such route can be found.
     */
    private function getRoute(string $path): ?Route{
        $reti = null;
        $retiLen = PHP_INT_MIN;
        if (count($this->routes) > 0){
            foreach($this->routes as $route){
                if ($route->matches($path) && $route->getLength() >= $retiLen){
                    $reti = $route;
                }
            }
        }
        return $reti;
    }
}

?>
