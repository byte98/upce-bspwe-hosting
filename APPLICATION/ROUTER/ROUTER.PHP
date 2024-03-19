<?php

//
// ROUTER.PHP
// File containing definition of application router.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Router;

USE SimpleHosting\Router\Route;
USE SimpleHosting\Application;
USE SimpleHosting\Controller\Controller;

/**
 * CLASS representing router of application.
 */
CLASS Router{

    /**
     * ARRAY with all available routes.
     */
    PRIVATE ARRAY $routes;

    /**
     * Creates NEW router.
     */
    PUBLIC FUNCTION __construct(){
        $this->routes = ARRAY();
    }

    /**
     * Adds route to router.
     * @param string $path Path of route.
     * @param Controller $controller Controller of route.
     */
    PUBLIC FUNCTION addRoute(string $path, Controller $controller){
        IF ($this->containsRoute($path) == false){
            array_push($this->routes, NEW Route($path, $controller));
            Application::logger()->info("NEW route added (" . $path . " ->  " . get_class($controller) . ")");
        }
        ELSE{
            Application::logger()->warning("Cannot add route: route already exists (" . $path . " ->  " . get_class($controller) . " is already routed to " . $this->getExactRouteName($path) . ")");
        }
    }

    /**
     * Checks, whether routing table already contains route with path.
     * @param string $path Path of route.
     * @RETURN bool TRUE IF route is in routing table,
     *              FALSE otherwise.
     */
    PRIVATE FUNCTION containsRoute(string $path){
        $reti = false;
        FOREACH($this->routes AS $route){
            IF ($route->equals($path)){
                $reti = true;
                BREAK;
            }
        }
        RETURN $reti;
    }

    /**
     * Gets name of controller of route.
     * @param string $path Path of route.
     * @RETURN string Name of controller of route.
     */
    PRIVATE FUNCTION getExactRouteName(string $path): string{
        $reti = "<unknown>";
        FOREACH($this->routes AS $route){
            IF ($route->equals($path)){
                $reti = get_class($route->getTarget());
                BREAK;
            }
        }
        RETURN $reti;
    }

    /**
     * Performs routing.
     * @param string $path Path of application.
     * @RETURN Route Route to which request should be routed,
     *                OR NULL IF no such route can be found.
     */
    PUBLIC FUNCTION route(string $path): ?Route{
        $reti = NULL;
        IF (count($this->routes) > 0){
            $route = $this->getRoute($path);
            IF ($route != null){
                $reti = $route;
            }
            ELSE{
                Application::logger()->warning("Cannot find controller FOR path '" . $path . "'");
            }
        }
        ELSE{
            Application::logger()->error("Routing table is EMPTY!");
        }
        RETURN $reti;
    }

    /**
     * Gets route associated with application path.
     * @param string $path Path of application.
     * @RETURN Route Route associated with application path,
     *                OR NULL IF no such route can be found.
     */
    PRIVATE FUNCTION getRoute(string $path): ?Route{
        $reti = null;
        $retiLen = PHP_INT_MIN;
        IF (count($this->routes) > 0){
            FOREACH($this->routes AS $route){
                IF ($route->matches($path) && $route->getLength() >= $retiLen){
                    $reti = $route;
                }
            }
        }
        RETURN $reti;
    }
}

?>
