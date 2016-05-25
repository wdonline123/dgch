<?php
namespace Profile\Controller;

use Application\Controller\FrontEnd;
use Zend\View\Model\ViewModel;

class IndexController extends FrontEnd
{
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
        $infoAccount = $this->infoAccount;
        
        $dbAdapterComment = $this->getServiceLocator()->get('Comment\Model\CommentTable');
        $aComment = $dbAdapterComment->getMyComment($infoAccount['account_id']);
        
        return new ViewModel(array(
            'infoAccount'   => $infoAccount,
            'aComment'      => $aComment
        ));
    }
    
    public function activitiesAction()
    {
        $infoAccount = $this->infoAccount;
        
        $dbAdapterComment = $this->getServiceLocator()->get('Comment\Model\CommentTable');
        $aComment = $dbAdapterComment->getMyComment($infoAccount['account_id']);
        
        return new ViewModel(array(
            'infoAccount'   => $infoAccount,
            'aComment'      => $aComment
        ));
    }
    
}

?>