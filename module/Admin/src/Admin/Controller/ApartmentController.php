<?php
namespace Admin\Controller;

use Apartment\Form\ApartmentForm;
use Zend\View\Model\ViewModel;

class ApartmentController extends BackEndController
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        $aSearch = array(
            //'agency_id'     => $this->params()->fromQuery('agency_id'),
            //'fullname'      => $this->params()->fromQuery('fullname'),
        );
        
        //echo "<pre>";
        //print_r($this->infoAdminUser);
        //echo "</pre>";
        
        $iLimit = 30;
        $iPage = (int)$this->params()->fromQuery('page', 1);
        $iOffset = ($iPage - 1) * $iLimit;
        	
        $paginator = $this->getAdapterTable()->getListAdmin($aSearch);
        $paginator->setCurrentPageNumber($iPage);
        $paginator->setItemCountPerPage($iLimit);
        
        return new ViewModel(array(
            'iOffset' => $iOffset,
            'aIsActive' => $this->getIsActive(),
            'aSearch' => $aSearch,
            'paginator' => $paginator,
        ));
    }
    
    public function addAction()
    {
        $aOption = array(
            'city' => $this->getLocations(),
            'district' => $this->getLocations(1)
        );
        
        $oForm = new ApartmentForm('frmAdd', $aOption);
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $oForm->addValidate();
            $oForm->setData($oRequest->getPost());
        
            if ( $oForm->isValid() ) {
                $aData = $oForm->getData();
                
                $id = $this->getAdapterTable()->insert($aData);
                
                return $this->redirect()->toRoute('admin/apartment');
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
        $id = $this->params()->fromQuery('id');
        $aOption = array(
            'city' => $this->getLocations(),
            'district' => $this->getLocations(1)
        );
        $oForm = new ApartmentForm('frmAdd', $aOption);
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
        
            $oForm->editValidate();
            $oForm->setData($aData);
        
            if ( $oForm->isValid() ) {
                $aData = $oForm->getData();
                $aData['modify_date'] = date("Y-m-d H:i:s");
                $this->getAdapterTable()->update($id, $aData);
                $this->processData($id);
                return $this->redirect()->toRoute('admin/apartment');
            }
            else {
                $aError = $oForm->getMessages();
                echo "<pre>";
                print_r($aError);
                echo "</pre>";
            }
        }
        
        $infoData = $this->getAdapterTable()->getData($id);
        $oForm->bind($infoData);
        return new ViewModel(array(
            'oForm' => $oForm,
        ));
    }
    
    public function locationAction()
    {
        $id = $this->params()->fromQuery('id');
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            $this->getAdapterTable()->update($id, $aData);
            return $this->redirect()->toRoute('admin/apartment');
        }
        
        $infoData = $this->getAdapterTable()->getData($id);
        return new ViewModel(array(
            'infoData' => $infoData,
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
    
    private function processData($id)
    {
        $infoData = $this->getAdapterTable()->getData($id);
        if ( isset($infoData['id']) ) {
            $sNameUrl = $this->convertTitleURL($infoData['name']);
            $aData = array(
                'name_url'  => $sNameUrl,
                'url'       => '/apartment/detail/' . $sNameUrl,
            );
            
            if ( empty($infoData['folder']) ) {
                $aData['folder'] = '/upload/'. (int)date('Y') .'/'. (int)date('m') .'/'. $id;
            }
            $this->getAdapterTable()->update($id, $aData);
        }
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Apartment\Model\ApartmentTable');
        }
        return $this->tbl_adapter;
    }
}

?>