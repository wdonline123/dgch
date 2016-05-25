<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class LocationController extends BackEndController
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        $iParent = (int)$this->params()->fromQuery('parent', 0);
        
        $aResult = $this->getAdapterTable()->getListAdmin($iParent);
        
        return new ViewModel(array(
            'aIsActive' => $this->getIsActive(),
            'aResult' => $aResult,
        ));
    }
    
    public function addAction()
    {
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            if ( !empty($aData['name']) ) {
                $this->getAdapterTable()->insert($aData);
                return $this->redirect()->toRoute('admin/location');
            }
        }
        
        $aParentLocation = $this->getAdapterTable()->getList(0);
        return new ViewModel(array(
            'aIsActive' => $this->getIsActive(),
            'aParentLocation' => $aParentLocation
        ));
    }
    
    public function editAction()
    {
        $id = $this->params()->fromQuery('id');
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            if ( !empty($aData['name']) ) {
                $this->getAdapterTable()->update($id, $aData);
                return $this->redirect()->toRoute('admin/location');
            }
        }
        
        $aParentLocation = $this->getAdapterTable()->getList(0);
        $infoData = $this->getAdapterTable()->getData($id);
        return new ViewModel(array(
            'aIsActive' => $this->getIsActive(),
            'aParentLocation' => $aParentLocation,
            'infoData' => $infoData
        ));
    }
    
    public function updateStatusAction()
    {
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            $id = $aData['id'];
            $iStatus = $aData['status'];
    
            if ($id > 0) {
                if ($iStatus == 1) {
                    $aUpdateData = array('isactive' => 0);
                }
                else {
                    $aUpdateData = array('isactive' => 1);
                }
                $this->getAdapterTable()->update($id, $aUpdateData);
            }
        }
        exit();
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Admin\Model\LocationTable');
        }
        return $this->tbl_adapter;
    }
}

?>