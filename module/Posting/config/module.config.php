<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Posting\Controller\Posting'                => 'Posting\Controller\PostingController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'posting' => __DIR__ . '/../view',
        ),
    ),
    'module_config' => array(
       
    ),
    'router' => array(
        'routes' => array(
            'posting' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/posting',
                    'defaults' => array (
                        'controller' => 'Posting\Controller\Posting',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'detail' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/detail/:id/:keyword',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'detail',
                            ),
                            'constraints' => array(
                                'id' => '[0-9-]*',
                                'keyword' => '[a-z0-9-]*',
                            ),
                        ),
                    ),
                    
                    'relation' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/relation',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'relation',
                            ),
                        ),
                    ),
                    'add' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'add',
                            ),
                        ),
                    ),
                    'add-buy' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/add-buy',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'addBuy',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/edit',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'edit',
                            ),
                        ),
                    ),
                    'edit-buy' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/edit-buy',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'editBuy',
                            ),
                        ),
                    ),
                    'add-media' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/add-media',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'addMedia',
                            ),
                        ),
                    ),
                    
                    'upload-picture' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/upload-picture',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'uploadPicture',
                            ),
                        ),
                    ),
                    'category' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/category[/:action]',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Category',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'search' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/search[/:action]',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Search',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'delete-picture' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/delete-picture',
                            'defaults' => array (
                                'controller' => 'Posting\Controller\Posting',
                                'action'     => 'deletePicture',
                            ),
                        ),
                    ),

                ),
            ),

        ),
    ),
);