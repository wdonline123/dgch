<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class AdminGroupController extends BackEndController
{
    protected $tbl_adapter;
    
    public function init()
    {
        
    }
    
    public function indexAction()
    {
        $aResult = $this->getAdapterTable()->fetchAll();
    
        return new ViewModel(array(
            'aResult' => $aResult,
        ));
    }
    
    public function addAction()
    {
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
    
            if ( !empty($aData['group_name']) ) {
                $this->getAdapterTable()->insert($aData);
                return $this->redirect()->toRoute('admin/group');
            }
        }
    }
    
    public function editAction()
    {
        $iGroupId = (int)$this->params()->fromQuery('id', 0);
    
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            if ( $iGroupId > 0 && !empty($aData['group_name']) ) {
                $this->getAdapterTable()->updateData($iGroupId, $aData);
                return $this->redirect()->toRoute('admin/group');
            }
        }
    
        $infoData = $this->getAdapterTable()->getData($iGroupId);
    
        return new ViewModel(array(
            'infoData' => $infoData,
        ));
    }
    
    public function deleteAction()
    {
        $objRequest = $this->getRequest();
        if ($objRequest->isPost()) {
            $arrData = $objRequest->getPost()->toArray();
            $iId = isset($arrData['id']) ? (int)$arrData['id'] : 0;
            $this->getAdapterTable()->deleteData($iId);
            echo $iId;
        }
        exit;
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Admin\Model\AdminGroupTable');
        }
        return $this->tbl_adapter;
    }
}

?>