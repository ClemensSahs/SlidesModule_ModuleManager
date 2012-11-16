<?php

namespace SlidesModule\ModuleManager;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module
    implements AutoloaderProviderInterface,
               ConfigProviderInterface
{
    public static $MODULE_DIR = null;

    public function getConfig()
    {
        return include_once static::$MODULE_DIR . DIRECTORY_SEPARATOR . 'config' .
                                                  DIRECTORY_SEPARATOR . 'module.config.php';
    }

    public function onBootstrap($e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
    
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                static::$MODULE_DIR . DIRECTORY_SEPARATOR . 'autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ ,
                ),
            ),
        );
    }
}
