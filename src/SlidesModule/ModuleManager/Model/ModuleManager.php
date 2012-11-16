<?php

namespace SlidesModule\ModuleManager\Model;

use Zend\Cache\Storage\StorageInterface;

class ModuleManager
{
    protected $_cache = null;
    protected $_modulePaths = null;
    protected $_moduleContainer = array();

    protected $_installedModule = null;
    protected $_enabledModule = null;

    public function setLocalModulePaths ($modulePaths)
    {
        $this->_modulePaths = $modulePaths;
    }

    public function setEnabledModules ($moduleList)
    {
        foreach ( $moduleList as $module ) {
            if ( is_string($module) ) {
                $module = $this->getModule($module);
            } elseif ( is_string($module) ) {
                $module = $this->getModule($module);
            }
        }
        $this->_enabledModule = $moduleList;
    }

    public function setCache ( StorageInterface $cache )
    {
        $this->_cache = $cache;
    }

    /**
     * @return StorageInterface
     */
    public function getCache ()
    {
        return $this->_cache;
    }

    public function hasModule ( $module)
    {
        if ( is_string($module) ) {
            return isset($this->_moduleContainer[ $module ]);
        } elseif ( is_object($module) && $module instanceof Module ) {
            return isset($this->_moduleContainer[ $module->getName() ]);
        } else {
            throw new \InvalidArgumentException('hastModule only accept string or a instance of "SlidesModule\ModuleManager\Moduel"');
        }
    }

    public function getModule( $moduleName )
    {
        return $this->_moduleContainer[ $moduleName ];
    }

    public function addModule( Module $module )
    {
        if ( $this->hasModule($module) ) {
            if ( $this->getModule($module->getName()) == $module ) {
                $this->_refeshModuleData($module);
                return true;
            }
            throw new \RuntimeException(sprintf('module with the name "%s" all ready exist, but its not the same',$module->getName()));
        }

        $this->_moduleContainer[ $module->getName() ] = $module;
        $this->_refeshModuleData($module);
    }

    protected function _refeshModuleData( Module $module )
    {
        if ( $module->isEnabled() ) {
            $this->_enabledModule[ $module->getName() ] = $module;
        } else {
            unset($this->_enabledModule[ $module->getName() ]);
        }

        if ( $module->isInstalled() ) {
            $this->_installedModule[ $module->getName() ] = $module;
        } else {
            unset($this->_installedModule[ $module->getName() ]);
        }
    }

    public function refeshModuleData( Module $module = null)
    {
        if ( $module !== null ) {
            $this->_refeshModuleData($module);
        }

        foreach ( $this->_moduleContainer as $module ) {
            if ( false === $module instanceof Module ) {
                throw new \RuntimeException('Module is not instance of "SlidesModule\ModuleManager\Moduel"');
            }

            $this->_refeshModuleData($module);
        }

    }

    public function getEnabledModule()
    {
        return $this->_enabledModule;
    }
    public function getAvailableModule()
    {
        return $this->_moduleContainer;
    }

    public function scanLocalAvailableModules ()
    {
        foreach ( $this->_modulePaths as $pathKey=>$path ) {

            if ( is_string($pathKey) && false === strpos($pathKey,'*') ) {

                if ( false === file_exists($path . DIRECTORY_SEPARATOR . 'module.php' ) ) {
                    continue;
                }

                $this->addModule(new Module(array(
                    'name'=>$pathKey,
                    'path'=>$path
                )));

            } else {

                $scanedDir = array_slice(scandir( $path ),2);

                foreach ( $scanedDir as $moduleName ) {
                    $modulePath = $path . DIRECTORY_SEPARATOR . $moduleName;

                    if ( false === file_exists($modulePath . DIRECTORY_SEPARATOR . 'module.php') ) {
                        continue;
                    }

                    if ( is_string($pathKey) ) {
                        $moduleName = str_replace('*', $moduleName, $pathKey);
                    }

                    $this->addModule(new Module(array(
                        'name'=>$moduleName,
                        'path'=>$modulePath
                    )));
                }
                unset($scanedDir,$moduleName,$modulePath);
            }
        }
    }

}
