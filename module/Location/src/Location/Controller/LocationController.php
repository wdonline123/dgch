<?php
namespace Location\Controller;

use Application\Controller\FrontEnd;
use Zend\View\Model\JsonModel;

class LocationController extends FrontEnd
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        
    }
    
    public function optionAction()
    {
        $iCityId = $this->params()->fromQuery('city_id', 0);
        $aLocation = $this->getAdapterTable()->getList($iCityId);
        
        $aResult = array();
        foreach ($aLocation as $item) {
            $aResult[$item['id']] = $item['name'];
        }
        
        return new JsonModel($aResult);
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Location\Model\LocationTable');
        }
        return $this->tbl_adapter;
    }
}

?>