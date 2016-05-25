<?php
namespace Like;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Like\Model\LikeTable;
use Zend\Db\TableGateway\TableGateway;

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
                'Like\Model\LikeTable' => function ($sm) {
                    $tableGateway = $sm->get('LikeTableGateway');
                    $table = new LikeTable($tableGateway);
                    return $table;
                },
                'LikeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('likes', $dbAdapter);
                },
    
    
            )
        );
    }
}

?>