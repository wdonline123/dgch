<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index'                => 'Admin\Controller\IndexController',
            'Admin\Controller\AdminGroup'      		=> 'Admin\Controller\AdminGroupController',
            'Admin\Controller\AdminUser'       		=> 'Admin\Controller\AdminUserController',
            'Admin\Controller\Location'             => 'Admin\Controller\LocationController',
            'Admin\Controller\Apartment'            => 'Admin\Controller\ApartmentController',
            'Admin\Controller\Comment'              => 'Admin\Controller\CommentController',
            'Admin\Controller\FileManagement'       => 'Admin\Controller\FileManagement',
            'Admin\Controller\Contact'              => 'Admin\Controller\ContactController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'admin/index'           => __DIR__ . '/../view/admin/index/layout.phtml',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array (
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'login' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/login',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Index',
                                'action'     => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/logout',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Index',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'change-password' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/change-password',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Index',
                                'action'     => 'changePassword',
                            ),
                        ),
                    ),                    
                    'group' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/group[/:action]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\AdminGroup',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'user' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/user[/:action]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\AdminUser',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'location' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/location[/:action]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Location',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'apartment' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/apartment[/:action]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Apartment',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'comment' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/comment[/:action]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Comment',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'file-management' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/file-management[/:action]',
                            'defaults' => array (
                                'controller' => 'admin\Controller\FileManagement',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'contact' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/contact[/:action]',
                            'defaults' => array (
                                'controller' => 'Admin\Controller\Contact',
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