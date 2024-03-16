<?php

// 
// APPLICATION.PHP
// File containing definition of application class.
//
// Author: Jiri Skoda<jiri.skoda@student.upce.cz>
//         Faculty of Electrical Engineering and Informatics
//         University of Pardubice
//         2024, Pardubice
//

namespace SimpleHosting;

use SimpleHosting\Model\DatabaseFactory;
use SimpleHosting\Router\Router;
use SimpleHosting\Router\RoutingTable;
use SimpleHosting\Utils\Logger\Logger;

/**
 * Class which represents application itself.
 */
class Application{

    /**
     * Path to file with configuration.
     */
    private readonly string $cFile;

    /**
     * Router of the application.
     */
    private Router $router;

    /**
     * Logger of application.
     */
    private static ?Logger $logger = null;

    /**
     * Creates new instance of application.
     * @param string $configFile Path to YAML file containing 
     *                           configuration of application.
     */
    public function __construct(string $configFile){
        $this->cFile = $configFile;
        $this->init();
    }

    /**
     * Initializes application.
     */
    private function init(): void{

        // Register class auto-loading
        spl_autoload_register(function($className){
           $path = Application::determineClassPath($className);
           if(file_exists($path)){
               require_once($path);
           } 
        });

        // Load configuration
        $config = new Configuration($this->cFile);
        Application::$logger = new Logger($config->getLoggerSettings());
        DatabaseFactory::setModel($config->getConnection());
        if ($config->getPHPErrors() == true){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }

        // Initialize router
        $this->router = new Router();
        $routingTable = new RoutingTable($config->getRoutes());
        $routingTable->fillRouter($this->router);
    }

    /**
     * Determines path to file with definition of class from
     * its name.
     * @param string $className Fully qualified name of class.
     * @return string Path to file with definition of class.
     */
    private static function determineClassPath(string $className): string{
        $reti = "";
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $rootPath = $_SERVER["DOCUMENT_ROOT"] . "/APPLICATION";
        $reti = $rootPath . DIRECTORY_SEPARATOR . strtoupper($classPath) . ".PHP";
        $reti = str_replace("SIMPLEHOSTING/", "", $reti);
        return $reti;
    }

    /**
     * Gets logger of whole application.
     * @return Logger Logger of whole application.
     */
    public static function logger(): Logger{
        $reti = Application::$logger;
        if ($reti == null){
            Application::$logger = Logger::none();
            $reti = Application::$logger;
        }
        return $reti;
    }

    /**
     * Gets view file.
     * @param string $viewName Name of view file.
     * @example Application::getView("homepage");
     */
    public static function getView(string $viewName){
        $path = $_SERVER["DOCUMENT_ROOT"] . "/APPLICATION/VIEW/" . $viewName . ".PHTML";
        if (file_exists($path)){
            include $path;
        }
        else{
            Application::logger()->warning("Cannot get view '" . $viewName . "': file does not exists!");
        }
    }

    /**
     * Runs application.
     */
    public function run(): void{
        $url = $_SERVER["REQUEST_URI"];
        $method = strtoupper($_SERVER["REQUEST_METHOD"]);
        Application::logger()->low("Incoming request [" . $method . "] " . $url);
        $route = $this->router->route($url);
        if ($route != null){
            Application::logger()->base("Giving control to '" . get_class($route->getTarget()) . "'");
            $data = $route->getData($url);
            switch($method){
                case "GET": $route->getTarget()->get($data); break;
                case "POST": $route->getTarget()->post($data); break;
            }
        }
        else{
            Application::logger()->warning("Cannot find controller for path '" . $url . "'");
        }
    }

    /**
     * Main function of whole application. This function
     * will be called after start of application.
     */
    public static function main(): void{
        
        // Path to file with debug configuration
        $config = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "DEBUG.YML";

        // Path to file with production configuration
        //$config = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "CONFIG.YML";

        
        $app = new \SimpleHosting\Application($config);
        $app->run();
        DatabaseFactory::close();
    }
}

?>
