<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Profile\Controller\Index'           => 'Profile\Controller\IndexController',
            'Profile\Controller\Posting'        => 'Profile\Controller\PostingController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'profile' => __DIR__ . '/../view',
        ),
       
    ),
    'router' => array(
        'routes' => array(
            'profile' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/profile',
                    'defaults' => array (
                        'controller' => 'Profile\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'activities' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/activities',
                            'defaults' => array (
                                'controller' => 'Profile\Controller\Index',
                                'action'     => 'activities',
                            ),
                        ),
                    ),
                    'posting' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/posting[/:action]',
                            'defaults' => array (
                                'controller' => 'Profile\Controller\Posting',
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