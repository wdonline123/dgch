<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Sitemap\Controller\Sitemap'           => 'Sitemap\Controller\SitemapController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'sitemap' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'sitemap' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/sitemap',
                    'defaults' => array (
                        'controller' => 'Sitemap\Controller\Sitemap',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    

                ),
            ),

        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
                'lastmod' => date("Y-m-d"),
                'changefreq' => 'weekly',
                'priority' => '1.0'
            ),
            array(
                'label' => 'Căn hộ cao cấp',
                'route' => 'vip',
                'lastmod' => date("Y-m-d"),
                'changefreq' => 'weekly',
                'priority' => '1.0'
            ),
            array(
                'label' => 'Căn hộ trung cấp',
                'route' => 'intermediate',
                'lastmod' => date("Y-m-d"),
                'changefreq' => 'weekly',
                'priority' => '1.0'
            ),
            
        )
    ),
);