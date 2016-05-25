<?php
namespace Profile\Controller;

use Application\Controller\FrontEnd;
use Zend\View\Model\ViewModel;
use Posting\Form\PostingForm;

class PostingController extends FrontEnd
{
    protected $tbl_adapter;
    
    public function init()
    {
        $infoAccount = $this->infoAccount;
        if ( !isset($infoAccount['account_id']) ) {
            return $this->redirect()->toRoute('login');
        }
        $this->layout()->sHeaderTitle = $infoAccount['fullname'];
    }
    
    public function indexAction()
    {
        $aFilter = array(
            'account_id' => $this->infoAccount['account_id']
        );
        
        $iLimit = 50;
        $iPage = (int)$this->params()->fromQuery('page', 1);
        $iOffset = ($iPage - 1) * $iLimit;
         
        $aPosting = $this->getAdapterTable()->getListByAccount($aFilter);
        $aPosting->setCurrentPageNumber($iPage);
        $aPosting->setItemCountPerPage($iLimit);
        
        return new ViewModel(array(
            'aPosting'         => $aPosting,
        ));
    }
    
    public function addAction()
    {
        $oPostingService = $this->getServiceLocator()->get('PostingService');
        $aPostingType = $oPostingService->getType();
        
        $aOption = array(
            'type' => $aPostingType,
            'city_id' => $this->getOptionLocation(),
            'district_id' => array(),
            'apartment_id' => array()
        );
        $oForm = new PostingForm('frmAdd', $aOption);
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aPostData = $oRequest->getPost()->toArray();
            $oForm->addValidate();
            $oForm->setData($oRequest->getPost());
            
            if ( $oForm->isValid() ) {
                $aData = $oForm->getData();
                /*
                echo "<pre>";
                print_r($aData);
                echo "</pre>";
                exit();
                */
            
                /*
                $oFile = $oRequest->getFiles()->toArray();
                if ( !empty($oFile['picture']['name']) ) {
                    $aData['picture'] = $this->uploadPicture($oFile['picture']);
                }
            
                if ( $aData['type_ad'] == 2 ) { // public now
                    $aData['public_date']   = date("Y-m-d H:i:s");
                    $aData['complete']      = 1;
                    $aData['status']        = 2;
                }
            
                
                */
                
                $aData['account_id'] = $this->infoAccount['account_id'];
                $aData['city_name'] = $aPostData['city_name'];
                $aData['district_name'] = $aPostData['district_name'];
                $aData['apartment_name'] = $aPostData['apartment_name'];
            
                $id = $this->getAdapterTable()->insert($aData);
                return $this->redirect()->toUrl('/profile/posting');
                
            }
            else {
                echo "<pre>";
                print_r($oForm->getMessages());
                echo "</pre>";
            }
        }
        
        return new ViewModel(array(
            'oForm'         => $oForm,
            'infoAccount'   => $this->infoAccount
        ));
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Posting\Model\PostingTable');
        }
        return $this->tbl_adapter;
    }
}

?>