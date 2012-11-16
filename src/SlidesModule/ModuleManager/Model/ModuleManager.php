<?php

namespace SlidesModule\ModuleManager\Model;

class ModuleManager
{
    protected $_modulePaths = null;
    protected $_moduleContainer = array();

    protected $_installedModule = null;
    protected $_enabledModule = null;

    public function setLocalModulePaths ($pathArray)
    {
    }

    public function setEnabledModules ($moduleList)
    {
    }

    public function hastModule ( $module)
    {
        if ( is_string($module) ) {
            $this->_moduleContainer[ $module ];
        } elseif ( is_object($module) && $module instanceof Module ) {
            $this->_moduleContainer[ $module->getName() ];
        } else {
            throw new \InvalidArgumentException('hastModule only accept string or a instance of "SlidesModule\ModuleManager\Moduel"');
        }
    }

    public function addModule( Module $module)
    {
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

    public function getModule( $moduleName )
    {
    }

    public function scanLocalAvailableModules ()
    {
        foreach ( $this->_modulePaths as $pathKey=>$path ) {

            if ( is_string($pathKey) && false === strpos($pathKey,'*') ) {

                if ( false === file_exists($path . DIRECTORY_SEPARATOR . 'module.php' ) ) {
                    continue;
                }

                $moduleScanRegister[ $pathKey ] = $path . DIRECTORY_SEPARATOR;

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
                    $moduleScanRegister[ $moduleName ]=$modulePath;
                }
            }
        }
    }

}
