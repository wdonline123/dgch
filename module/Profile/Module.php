<?php
namespace Profile;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\TableGateway;
use Profile\Model\AccountTable;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $serviceManager         = $e->getApplication()->getServiceManager();
        $dbAdapter              = $serviceManager->get('Zend\Db\Adapter\Adapter');
        GlobalAdapterFeature::setStaticAdapter($dbAdapter);
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
                'AuthServiceFront' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'accounts', 'email', 'password', 'MD5(?)');
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    return $authService;
                },
                
                'Profile\Model\AccountTable' => function ($sm) {
                    $tableGateway = $sm->get('AccountTableGateway');
                    $table = new AccountTable($tableGateway);
                    return $table;
                },
                'AccountTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('accounts', $dbAdapter);
                },
    
    
            )
        );
    }
}

?>