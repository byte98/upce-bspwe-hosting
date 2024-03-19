<?php

//
// ROUTINGTABLE.PHP
// File containing some utility to build routing table.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting\Router;

USE SimpleHosting\Application;
USE SimpleHosting\Router\Router;

/**
 * CLASS which serves AS utility CLASS FOR building routing table
 * FOR application router.
 */
CLASS RoutingTable{
    /**
     * Configuration parsed from file.
     */
    PRIVATE ARRAY $config;

    /**
     * Routes parsed from configuration.
     */
    PRIVATE ARRAY $routes;

    /**
     * Creates NEW utilty FOR building routing table.
     * @param ARRAY $config Routes from configuration.
     */
    PUBLIC FUNCTION __construct(ARRAY $config){
        $this->config = $config;
        $this->routes = ARRAY();
        $this->parseConfig();
    }

    /**
     * Parses configuration AND builds routing table.
     */
    PRIVATE FUNCTION parseConfig(): void{
        $prefix = "SimpleHosting\\Controller\\";
        $iController = "SimpleHosting\\Controller\\Controller";
        FOREACH($this->config AS $key => $value){
            $className = $prefix . $value;
            IF (class_exists($className)){
                IF (in_array($iController, class_implements($className))){
                    IF (array_key_exists($key, $this->routes)){
                        Application::logger()->info("Route to " . $key . " already exists; overwriting.");
                        UNSET($this->routes[$key]);
                    }
                    $this->routes[$key] = NEW $className();
                }
                ELSE{
                    Application::logger()->warning("Cannot parse routes: CLASS ". $className ." is not controller!");
                }
            }
            ELSE{
                Application::logger()->warning("Cannot parse routes: CLASS ". $className ." does not exists!");
            }
        }
    }

    /**
     * Fills given router with routes from routing table.
     * @param Router $router Router to be filled.
     */
    PUBLIC FUNCTION fillRouter(Router $router): void{
        FOREACH ($this->routes AS $key => $value) {
            $router->addRoute($key, $value);
        }
    }

}

?>
