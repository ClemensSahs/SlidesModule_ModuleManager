<?php

namespace SlidesModule\ModuleManager\Service;

use Zend\Cache\StorageFactory;

use SlidesModule\ModuleManager\Model\ModuleManager;

use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\ServiceManager\FactoryInterface;

class ModuleManagerFactory
    implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appConfig = $serviceLocator->get('applicationconfig');

        $moduleManager = new ModuleManager();
        $moduleManager->setLocalModulePaths($appConfig['module_listener_options']['module_paths']);
        $moduleManager->setEnabledModules($appConfig['modules']);

        $moduleManager->setCache(StorageFactory::factory(array(
            'adapter' => array(
                'name'=>'memory',
                'options' => array(
                    'namespace' => 'module-manager'
                ),
            ),
            'plugins' => array(
                    'exception_handler' => array('throw_exceptions' => false),
            ),
        )));

        return $moduleManager;
    }
}
