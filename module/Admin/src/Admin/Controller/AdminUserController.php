<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Admin\Form\AdminUserForm;

class AdminUserController extends BackEndController
{
    protected $tbl_adapter;
    
    public function init()
    {
        
    }
    
    public function indexAction()
    {
        $aResult = $this->getAdapterTable()->fetchAll();       
        
        return new ViewModel(array(
            'aGroup'    => $this->getGroup(),
            'aStatus'   => $this->getStatus(),
            'aResult'   => $aResult,
        ));
    }
    
    public function addAction()
    {
        $aOption = array(
            'group' => $this->getGroup()
        );
        
        $oForm = new AdminUserForm('frmAdd', $aOption);
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $oForm->addValidate();
            $oForm->setData($oRequest->getPost());
        
            if ( $oForm->isValid() ) {
                $aData = $oForm->getData();
                unset($aData['retype-password']);
                $aData['password'] = md5($aData['password']);
                $this->getAdapterTable()->insert($aData);
                return $this->redirect()->toRoute('admin/user');
            }
            else {
                $aError = $oForm->getMessages();
                echo "<pre>";
                print_r($aError);
                echo "</pre>";
            }
        }
        
        return new ViewModel(array(
            'oForm' => $oForm,
        ));
    }
    
    public function editAction()
    {
        $id     = (int) $this->params()->fromQuery('id', 0);
        $aOption = array(
            'group' => $this->getGroup()
        );
        
        $oForm = new AdminUserForm('frmAdd', $aOption);
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $oForm->editValidate($id);
            $oForm->setData($oRequest->getPost());
        
            if ( $oForm->isValid() ) {
                $aData = $oForm->getData();
                unset($aData['retype-password']);
                unset($aData['password']);
                $this->getAdapterTable()->update($id, $aData);
                return $this->redirect()->toRoute('admin/user');
            }
        }
        
        $infoData = $this->getAdapterTable()->getData($id);
        $oForm->bind($infoData);
        return new ViewModel(array(
            'oForm' => $oForm,
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
    
    public function updateStatusAction()
    {
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            $id = $aData['id'];
            $iStatus = $aData['status'];
    
            if ($id > 0) {
                if ($iStatus == 1) {
                    $aUpdateData = array('status' => 0);
                }
                else {
                    $aUpdateData = array('status' => 1);
                }
                $this->getAdapterTable()->update($id, $aUpdateData);
            }
        }
        exit();
    }
    
    public function getGroup()
    {
        $dbAdapter = $this->getServiceLocator()->get('Admin\Model\AdminGroupTable');
        $oGroup = $dbAdapter->fetchAll();
        
        $aResult = array();
        foreach ($oGroup as $item) {
            $aResult[$item['group_id']] = $item['group_name'];
        }
        return $aResult;
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Admin\Model\AdminUserTable');
        }
        return $this->tbl_adapter;
    }
}

?>