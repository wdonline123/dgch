<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

class FrontEnd extends AbstractActionController
{
    public $infoAccount;
    
    public function onDispatch(MvcEvent $e)
    {
        $oAuth = $this->getServiceLocator()->get('AuthServiceFront');
    
        if ( $oAuth->hasIdentity() ) {
            $sEmail = $oAuth->getIdentity();
            $dbAdapterAccount = $this->getServiceLocator()->get('Profile\Model\AccountTable');
            $infoAccount = $dbAdapterAccount->getDataByEmail($sEmail);
            $this->layout()->infoAccount = $infoAccount;
            $this->infoAccount = $infoAccount;
        }
    
        $this->layout()->sHeaderTitle = 'Định giá căn hộ';
        $this->layout()->sSiteAuthor = '';
        $this->layout()->sSiteDescription = '';
        $this->layout()->sSiteKeywords = '';
        $this->layout()->sSitePage = 'home';
    
        $this->init();
        parent::onDispatch($e);
    }
    
    public function init()
    {
    
    }
    
    public function getRouteMatch()
    {
        if (empty($this->routeMatch)) {
            $this->routeMatch = $this->getEvent()->getRouteMatch();
        }
    
        return $this->routeMatch;
    }
       
    public function printObj($aResult)
    {
        foreach ($aResult as $item) {
            echo "<pre>";
            print_r($item);
            echo "</pre>";
        }
    }
    
    public function getOptionLocation($iCityId = 0)
    {
        $dbAdapter = $this->getServiceLocator()->get('Location\Model\LocationTable');
        $aLocation = $dbAdapter->getList($iCityId);
        
        $aResult = array();
        foreach ($aLocation as $item) {
            $aResult[$item['id']] = $item['name'];
        }
        
        return $aResult;
    }
}

?>