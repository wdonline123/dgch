<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Apartment\Controller\Index'           => 'Apartment\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'apartment' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        
    ),
    'router' => array(
        'routes' => array(
            'apartment' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/apartment',
                    'defaults' => array (
                        'controller' => 'Apartment\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(

                    'most-view' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/most-view',
                            'defaults' => array (
                                'controller' => 'Apartment\Controller\Index',
                                'action'     => 'most-view',
                            ),
                        ),
                    ),
                    
                    'option' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/option',
                            'defaults' => array (
                                'controller' => 'Apartment\Controller\Index',
                                'action'     => 'option',
                            ),
                        ),
                    ),
                    
                    'detail' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/detail/:name-url',
                            'defaults' => array (
                                'controller' => 'Apartment\Controller\Index',
                                'action'     => 'detail',
                            ),
                            'constraints' => array(
                                'name-url' => '[a-z0-9-]*',
                            ),
                        ),
                    ),
                    

                ),
            ),

        ),
    ),
);