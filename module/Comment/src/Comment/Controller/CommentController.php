<?php
namespace Comment\Controller;

use Application\Controller\FrontEnd;
use Zend\View\Model\ViewModel;
use Comment\Form\CommentForm;


class CommentController extends FrontEnd
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        //$infoAccount = $this->getInfoAccount();
         
        $aComment = array();
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData          = $oRequest->getPost()->toArray();
            $iObjectId      = isset($aData['object_id']) ? $aData['object_id'] : 0;
            $iObjectType    = isset($aData['object_type']) ? $aData['object_type'] : 1;
            $aComment       = $this->getComment($iObjectId, $iObjectType);
        }
        
        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            //'infoAccount' => $infoAccount,
            'aComment' => $aComment
        ));
        	
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    protected function getComment($iObjectId, $iObjectType)
    {
        $aResult = $this->getAdapterTable()->getLst($iObjectId, $iObjectType);
         
        $aComment = array();
        $aSubComment = array();
        foreach ($aResult as $item) {
            if ($item['comment_parent'] > 0) {
                $aSubComment[] = $item;
            }
            else {
                $aComment[] = $item;
            }
        }
    
        if ( count($aSubComment) > 0 ) {
            foreach ($aComment as &$comment) {
                foreach ($aSubComment as &$subComment) {
                    if ($comment['comment_id'] == $subComment['comment_parent']) {
                        $comment['sub_comment'][] = $subComment;
                        unset($subComment);
                    }
                }
            }
        }
    
        return $aComment;
    }
    
    public function addAction()
    {
        $id = 0;
        $oForm = new CommentForm('frmComment', null);
        $infoAccount = 
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            $oForm->addValidate($aData['min_price'], $aData['max_price']);
            $oForm->setData($oRequest->getPost());
            
            if ( $oForm->isValid() ) {
                $aData = $oForm->getData();
                
                if ( isset($this->infoAccount['account_id']) ) {
                    $aData['account_id']    = $this->infoAccount['account_id'];
                    $aData['fullname'] 		= $this->infoAccount['fullname'];
                    $aData['avatar'] 	    = $this->infoAccount['avatar'];
                }
                
                $id = $this->getAdapterTable()->insert($aData);
                if ($id > 0) {                    
                    $aDataApartment = array(
                        'number_comment' => new \Zend\Db\Sql\Expression("number_comment + 1"),
                    );
                    $dbAdapterApartment = $this->getServiceLocator()->get('Apartment\Model\ApartmentTable');
                    $dbAdapterApartment->update($aData['object_id'], $aDataApartment);
                }
            }
            else {
                
                $sError = '';
                $aError = $oForm->getMessages();
                
                foreach ($aError as $level1) {
                    foreach ($level1 as $level2) {
                        if ( !empty($sError) ) {
                            $sError = $sError .'<br>'. $level2;
                        }
                        else {
                            $sError = $level2;
                        }
                    }
                }
                
                echo $sError;
                exit;
            }
        }
        
        echo $id;
        exit();
    }
    
    public function addChildAction()
    {
        if ( !isset($this->infoAccount['account_id']) ) {
            exit;
        }
        
        $id = 0;
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            
            if ( !empty($aData['comment_content']) ) {
                $aData['account_id']    = $this->infoAccount['account_id'];
                $aData['fullname'] 		= $this->infoAccount['fullname'];
                $aData['avatar'] 	    = $this->infoAccount['avatar'];
            
                $id = $this->getAdapterTable()->insert($aData);
                if ($id > 0) {
                    $iParentId = isset($aData['comment_parent']) ? $aData['comment_parent'] : 0;
                    $aData = array(
                        'number_comment' => new \Zend\Db\Sql\Expression("number_comment + 1"),
                    );
                    $this->getAdapterTable()->update($iParentId, $aData);
                }
            }
        }
        echo $id;
        exit();
    }
    
    public function infoAction()
    {
        $infoComment = array();
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            $id = isset($aData['id']) ? $aData['id'] : 0;
            $infoComment = $this->getAdapterTable()->getData($id);
        }
        
        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'infoComment'       => $infoComment,
            'infoAccount'       => $this->infoAccount,
        ));
        
        return $viewModel->setTerminal(true);
    }
    
    public function childAction()
    {
        $infoComment = array();
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            $id = isset($aData['id']) ? $aData['id'] : 0;
            $infoComment = $this->getAdapterTable()->getData($id);
        }
    
        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'comment' => $infoComment
        ));
    
        return $viewModel->setTerminal(true);
    }
    
    public function listChildAction()
    {
        $aComment = array();
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            $id = isset($aData['id']) ? $aData['id'] : 46;
            $aComment = $this->getAdapterTable()->getChildComment($id);
        }
            
        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'aComment' => $aComment
        ));
        
        return $viewModel->setTerminal(true);
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Comment\Model\CommentTable');
        }
        return $this->tbl_adapter;
    }
}

?>