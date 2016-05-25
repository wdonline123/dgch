<?php
namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Db\TableGateway\TableGateway;
use Admin\Model\AdminUserTable;
use Admin\Model\AdminGroupTable;
use Admin\Model\LocationTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AuthServiceBackEnd' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'admin_user', 'username', 'password', 'MD5(?) and status=1');
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    return $authService;
                },
                'Admin\Model\AdminGroupTable' => function ($sm) {
                    $tableGateway = $sm->get('AdminGroupTableGateway');
                    $table = new AdminGroupTable($tableGateway);
                    return $table;
                },
                'AdminGroupTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('admin_group', $dbAdapter);
                },
                'Admin\Model\AdminUserTable' => function ($sm) {
                    $tableGateway = $sm->get('AdminUserTableGateway');
                    $table = new AdminUserTable($tableGateway);
                    return $table;
                },
                'AdminUserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('admin_user', $dbAdapter);
                },
                'Admin\Model\LocationTable' => function ($sm) {
                    $tableGateway = $sm->get('LocationTableGateway');
                    $table = new LocationTable($tableGateway);
                    return $table;
                },
                'LocationTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('location', $dbAdapter);
                },
                
                
            )
        );
    
    }
}

?>