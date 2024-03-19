<?php

// 
// APPLICATION.PHP
// File containing definition of application CLASS.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering AND Informatics
//         University of Pardubice
//         2024, Pardubice
//

NAMESPACE SimpleHosting;

USE SimpleHosting\Model\DatabaseFactory;
USE SimpleHosting\Router\Router;
USE SimpleHosting\Router\RoutingTable;
USE SimpleHosting\Utils\Logger\Logger;

/**
 * CLASS which represents application itself.
 */
CLASS Application{

    /**
     * Path to file with configuration.
     */
    PRIVATE readonly string $cFile;

    /**
     * Router of the application.
     */
    PRIVATE Router $router;

    /**
     * Logger of application.
     */
    PRIVATE STATIC ?Logger $logger = null;

    /**
     * Creates NEW instance of application.
     * @param string $configFile Path to YAML file containing 
     *                           configuration of application.
     */
    PUBLIC FUNCTION __construct(string $configFile){
        $this->cFile = $configFile;
        $this->init();
    }

    /**
     * Initializes application.
     */
    PRIVATE FUNCTION init(): void{

        // Register CLASS auto-loading
        spl_autoload_register(FUNCTION($className){
           $path = Application::determineClassPath($className);
           IF(file_exists($path)){
               REQUIRE_ONCE($path);
           } 
        });

        // Load configuration
        $config = NEW Configuration($this->cFile);
        Application::$logger = NEW Logger($config->getLoggerSettings());
        DatabaseFactory::setModel($config->getConnection());
        IF ($config->getPHPErrors() == true){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }

        // Initialize router
        $this->router = NEW Router();
        $routingTable = NEW RoutingTable($config->getRoutes());
        $routingTable->fillRouter($this->router);
    }

    /**
     * Determines path to file with definition of CLASS from
     * its name.
     * @param string $className Fully qualified name of CLASS.
     * @RETURN string Path to file with definition of CLASS.
     */
    PRIVATE STATIC FUNCTION determineClassPath(string $className): string{
        $reti = "";
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $rootPath = $_SERVER["DOCUMENT_ROOT"] . "/APPLICATION";
        $reti = $rootPath . DIRECTORY_SEPARATOR . strtoupper($classPath) . ".PHP";
        $reti = str_replace("SIMPLEHOSTING/", "", $reti);
        RETURN $reti;
    }

    /**
     * Gets logger of whole application.
     * @RETURN Logger Logger of whole application.
     */
    PUBLIC STATIC FUNCTION logger(): Logger{
        $reti = Application::$logger;
        IF ($reti == null){
            Application::$logger = Logger::none();
            $reti = Application::$logger;
        }
        RETURN $reti;
    }

    /**
     * Gets view file.
     * @param string $viewName Name of view file.
     * @example Application::getView("homepage");
     */
    PUBLIC STATIC FUNCTION getView(string $viewName){
        $path = $_SERVER["DOCUMENT_ROOT"] . "/APPLICATION/VIEW/" . $viewName . ".PHTML";
        IF (file_exists($path)){
            INCLUDE $path;
        }
        ELSE{
            Application::logger()->warning("Cannot get view '" . $viewName . "': file does not exists!");
        }
    }

    /**
     * Runs application.
     */
    PUBLIC FUNCTION run(): void{
        $url = $_SERVER["REQUEST_URI"];
        $method = strtoupper($_SERVER["REQUEST_METHOD"]);
        Application::logger()->low("Incoming request [" . $method . "] " . $url);
        $route = $this->router->route($url);
        IF ($route != null){
            Application::logger()->base("Giving control to '" . get_class($route->getTarget()) . "'");
            $data = $route->getData($url);
            SWITCH($method){
                CASE "GET": $route->getTarget()->get($data); BREAK;
                CASE "POST": $route->getTarget()->post($data); BREAK;
            }
        }
        ELSE{
            Application::logger()->warning("Cannot find controller FOR path '" . $url . "'");
        }
    }

    /**
     * Main FUNCTION of whole application. This FUNCTION
     * will be called after start of application.
     */
    PUBLIC STATIC FUNCTION main(): void{
        
        // Path to file with debug configuration
        $config = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "DEBUG.YML";

        // Path to file with production configuration
        //$config = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "CONFIG.YML";

        
        $app = NEW \SimpleHosting\Application($config);
        $app->run();
        DatabaseFactory::close();
    }
}

?>
