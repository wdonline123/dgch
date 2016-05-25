<?php
namespace Contact\Controller;

use Application\Controller\FrontEnd;
use Zend\View\Model\ViewModel;
use Contact\Form\ContactForm;

class ContactController extends FrontEnd
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        $sAct = $this->params()->fromQuery('act', '');
        $aOption = array();
        $oForm = new ContactForm('frmContact', $aOption);
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $oForm->addValidate();
            $oForm->setData($oRequest->getPost());
            if ( $oForm->isValid() ) {
                $aData = $oForm->getData();
                $this->getAdapterTable()->insert($aData);
                return $this->redirect()->toUrl('/lien-he?act=send');
            }
        }
        
        $this->layout()->sHeaderTitle = 'Liên hệ';
        return new ViewModel(array(
            'sAct' => $sAct,
            'oForm' => $oForm,
        ));
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Contact\Model\ContactTable');
        }
        return $this->tbl_adapter;
    }
}

?>