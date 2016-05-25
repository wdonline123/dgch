<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Contact\Controller\Contact'            => 'Contact\Controller\ContactController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'contact' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'contact' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/lien-he[/:action]',
                    'defaults' => array (
                        'controller' => 'Contact\Controller\Contact',
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