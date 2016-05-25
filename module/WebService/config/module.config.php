<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'WebService\Controller\Index'          => 'WebService\Controller\IndexController',
            'WebService\Controller\BinhAnh'        => 'WebService\Controller\BinhAnhController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'web-service' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'ws' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/ws',
                    'defaults' => array (
                        'controller' => 'WebService\Controller\Index',
                        'action'     => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'binh-anh' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/binh-anh[/:action]',
                            'defaults' => array (
                                'controller' => 'WebService\Controller\BinhAnh',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    

                ),
            ),

        ),
    ),
);