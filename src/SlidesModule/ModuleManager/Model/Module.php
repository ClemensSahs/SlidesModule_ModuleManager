<?php

namespace SlidesModule\ModuleManager\Model;

class Module
{
    public $_isInstalled = null;
    public $_isEnabled = null;
    public $_path = null;
    public $_name = null;

    public function __construct($options)
    {
        $this->_path = $options['path'];
        $this->_name = $options['name'];
    }

    public function isInstalled()
    {
        return $this->_isInstalled;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function isEnabled()
    {
        return $this->_isEnabled;
    }

    public function install()
    {
        // workflow for installing the module

        $this->enable();
    }

    public function deinstall()
    {
        $this->disable();

        // workflow for deinstalling the module
    }

    public function enable()
    {
    }

    public function disable()
    {
    }
}
