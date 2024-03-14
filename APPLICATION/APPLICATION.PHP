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

/**
 * Class which represents application itself.
 */
class Application{

    /**
     * Path to file with configuration.
     */
    private string $cFile;

    /**
     * Logger of application.
     */
    private static Logger $logger;

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
        $this->logger = new Logger($config->getLogLevel(), $config->getLogDir());
        DatabaseFactory::setModel($config->getConnection());
        if ($config->getPHPErrors() == true){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
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
        $rootPath = $_SERVER["DOCUMENT_ROOT"] . '/APPLICATION';
        $reti = $rootPath . DIRECTORY_SEPARATOR . strtoupper($classPath) . '.PHP';
        $reti = str_replace("SIMPLEHOSTING/", "", $reti);
        echo($className . " -> " . $reti . "<br>");
        return $reti;
    }

    /**
     * Gets logger of whole application.
     * @return Logger Logger of whole application.
     */
    public static function logger(): Logger{
        return Application::$logger;
    }

    /**
     * Runs application.
     */
    public function run(): void{

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
