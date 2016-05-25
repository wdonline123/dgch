<?php
namespace Posting;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\TableGateway;
use Posting\Model\PostingTable;

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
    
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'PostingUrl' => 'Posting\View\Helper\PostingUrl',
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Posting\Model\PostingTable' => function ($sm) {
                    $tableGateway = $sm->get('PostingTableGateway');
                    $table = new  PostingTable($tableGateway);
                    return $table;
                },
                'PostingTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('posting', $dbAdapter);
                },
    
            ),
            
            'invokables' => array(
                'PostingService' => 'Posting\Service\PostingService'
            )
        );
    }
}

?>