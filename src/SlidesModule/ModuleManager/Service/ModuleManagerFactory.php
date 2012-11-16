<?php

namespace SlidesModule\ModuleManager\Service;

use SlidesModule\ModuleManager\Model\ModuleManager;

use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\ServiceManager\FactoryInterface;

class ModuleManagerFactory
    implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appConfig = $this->getServiceLocator()->get('applicationconfig');

        $moduleManager = new ModuleManager();
        $moduleManager->setEnabledModules($appConfig['module_listener_options']['module_paths']);
        $moduleManager->setLocalModulePaths($appConfig['modules']);

        return $moduleManager;
    }
}
