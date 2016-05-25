<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Comment\Controller\Comment'            => 'Comment\Controller\CommentController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'comment' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'comment' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/comment[/:action]',
                    'defaults' => array (
                        'controller' => 'Comment\Controller\Comment',
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