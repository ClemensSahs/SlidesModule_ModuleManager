<?php

namespace SlidesModule\ModuleManager\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ModuleController
    extends AbstractActionController
{
    public function indexAction ()
    {
        return array();
    }
    public function scanAction ()
    {
        /* @var $moduleManager \SlidesModule\ModuleManager\Model\ModuleManager */
        $moduleManager = $this->getServiceLocator()->get('slides-module-manager');

        $moduleManager->scanLocalAvailableModules();

        return array(
            'availableModule'=>$moduleManager->getAvailableModule(),
            'enabledModule'=>$moduleManager->getEnabledModule()
        );
    }
    public function enableAction ()
    {
        return array();
    }
    public function disenableAction ()
    {
        return array();
    }
    public function installAction ()
    {
        return array();
    }
    public function uninstallAction ()
    {
        return array();
    }
}
