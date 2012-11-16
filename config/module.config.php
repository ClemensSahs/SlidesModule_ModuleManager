<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'SlidesModule\ModuleManager\Controller\Module'     => 'SlidesModule\ModuleManager\Controller\ModuleController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'sw-module-manager' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/module-manager',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SlidesModule\ModuleManager\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(

                    'module' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/module',
                            'defaults' => array(
                                'controller' => 'Module',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(

                            'index' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/index',
                                    'defaults' => array(
                                        'controller' => 'Module',
                                        'action'     => 'index',
                                    ),
                                ),
                            ),

                            'list' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        'controller' => 'Module',
                                        'action'     => 'list',
                                    ),
                                ),
                            ),

                            'scan' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/scan',
                                    'defaults' => array(
                                        'controller' => 'Module',
                                        'action'     => 'scan',
                                    ),
                                ),
                            ),

                        ),
                    ),

                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'layout'                   => 'layout/slides-module-manager',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
