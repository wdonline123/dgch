<?php
namespace Contact;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Contact\Model\ContactTable;
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
                'Contact\Model\ContactTable' => function ($sm) {
                    $tableGateway = $sm->get('ContactTableGateway');
                    $table = new ContactTable($tableGateway);
                    return $table;
                },
                'ContactTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('contacts', $dbAdapter);
                },
    
    
            )
        );
    }
}

?>