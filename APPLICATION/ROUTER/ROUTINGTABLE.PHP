<?php

//
// ROUTINGTABLE.PHP
// File containing some utility to build routing table.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting\Router;

use SimpleHosting\Application;
use SimpleHosting\Router\Router;

/**
 * Class which serves as utility class for building routing table
 * for application router.
 */
class RoutingTable{
    /**
     * Configuration parsed from file.
     */
    private array $config;

    /**
     * Routes parsed from configuration.
     */
    private array $routes;

    /**
     * Creates new utilty for building routing table.
     * @param array $config Routes from configuration.
     */
    public function __construct(array $config){
        $this->config = $config;
        $this->routes = array();
        $this->parseConfig();
    }

    /**
     * Parses configuration and builds routing table.
     */
    private function parseConfig(): void{
        $prefix = "SimpleHosting\\Controller\\";
        $iController = "SimpleHosting\\Controller\\Controller";
        foreach($this->config as $key => $value){
            $className = $prefix . $value;
            if (class_exists($className)){
                if (in_array($iController, class_implements($className))){
                    if (array_key_exists($key, $this->routes)){
                        Application::logger()->info("Route to " . $key . " already exists; overwriting.");
                        unset($this->routes[$key]);
                    }
                    $this->routes[$key] = new $className();
                }
                else{
                    Application::logger()->warning("Cannot parse routes: class ". $className ." is not controller!");
                }
            }
            else{
                Application::logger()->warning("Cannot parse routes: class ". $className ." does not exists!");
            }
        }
    }

    /**
     * Fills given router with routes from routing table.
     * @param Router $router Router to be filled.
     */
    public function fillRouter(Router $router): void{
        foreach ($this->routes as $key => $value) {
            $router->addRoute($key, $value);
        }
    }

}

?>
