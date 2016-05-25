<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Like\Controller\Like'            => 'Like\Controller\LikeController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'like' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'like' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/like[/:action]',
                    'defaults' => array (
                        'controller' => 'Like\Controller\Like',
                        'action'     => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),


        ),
    ),
);