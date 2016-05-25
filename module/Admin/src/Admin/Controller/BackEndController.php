<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

class BackEndController extends AbstractActionController
{
    protected $routeMatch = null;
    protected $infoAdminUser = null;
    
    public function onDispatch(MvcEvent $e)
    {
        $resultResponse = $this->construct();
         
        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('admin/index');
         
        if ( !empty($resultResponse) ) {
            return $resultResponse;
        }
    
        $this->init();
        return parent::onDispatch($e);
    }
    
    public function init()
    {
    
    }
    
    protected function construct()
    {
        $auth = $this->getServiceLocator()->get('AuthServiceBackEnd');
        if ( $auth->hasIdentity() ) {
            $sUsername = $auth->getIdentity();
            $this->setInfoAdminUser($sUsername);
            $this->layout()->infoAdminUser = $this->getInfoAdminUser();
            $this->layout()->controller = $this->getEvent()->getRouteMatch()->getParam('controller');
        }
        else {
            $routeName = $this->getRouteMatch()->getMatchedRouteName();
            if ($routeName != 'admin/login') {
                return $this->redirect()->toRoute('admin/login');
            }
        }
    }
    
    public function getRouteMatch()
    {
        if (empty($this->routeMatch)) {
            $this->routeMatch = $this->getEvent()->getRouteMatch();
        }
    
        return $this->routeMatch;
    }
    
    public function getInfoAdminUser()
    {
        return $this->infoAdminUser;
    }
    
    protected function setInfoAdminUser($sUsername)
    {
        $oAdminUser = $this->getServiceLocator()->get('Admin\Model\AdminUserTable');
        $this->infoAdminUser = $oAdminUser->getDataByUsername($sUsername);
    }
    
    public function getLocations($iParent = 0)
    {
        $aResult = array();
        $dbAdapter = $this->getServiceLocator()->get('Admin\Model\LocationTable');
        $oLocation = $dbAdapter->getList($iParent);
        
        foreach ($oLocation as $item) {
            $aResult[$item['id']] = $item['name'];
        }
        return $aResult;
    }
    
    public function convertTitleURL($strText = '') {
        $strText = trim(mb_strtolower($strText, 'utf-8'));
        $char_unicode = array(
            '#ạ|á|à|ả|ã|â|ậ|ấ|ầ|ẩ|ẫ|ă|ặ|ắ|ằ|ẳ|ẫ#i',
            '#ê|ẹ|é|è|ẻ|ẽ|ế|ề|ể|ễ|ệ#i',
            '#ọ|ộ|ổ|ỗ|ố|ồ|ô|ó|ò|ỏ|õ|ơ|ợ|ớ|ờ|ở|ỡ#i',
            '#ụ|ư|ứ|ừ|ử|ữ|ự|ú|ù|ủ|ũ#i',
            '#ị|í|ì|ỉ|ĩ#i',
            '#ỵ|ý|ỳ|ỷ|ỹ#i',
            '#đ#i',
            '#[^a-zA-Z0-9\s]#i',
            '#[\s]#i'
        );
        $char_EN = array( 'a','e','o','u','i','y','d','','-');
        $strText = preg_replace($char_unicode, $char_EN, $strText);
        return str_replace('--', '-', $strText);
    }
    
    public function getIsActive()
    {
        return array(
            0 => 'Inactive',
            1 => 'Active'
        );
    }
    
    public function getStatus()
    {
        return array(
            0 => 'Inactive',
            1 => 'Active'
        );
    }
}

?>