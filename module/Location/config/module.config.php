<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Location\Controller\Location'            => 'Location\Controller\LocationController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'location' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'location' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/location[/:action]',
                    'defaults' => array (
                        'controller' => 'Location\Controller\Location',
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
?>