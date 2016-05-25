<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class ContactController extends BackEndController
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        $iLimit = 30;
        $iPage = (int)$this->params()->fromQuery('page', 1);
        $iOffset = ($iPage - 1) * $iLimit;
         
        $paginator = $this->getAdapterTable()->getListAdmin();
        $paginator->setCurrentPageNumber($iPage);
        $paginator->setItemCountPerPage($iLimit);
    
        return new ViewModel(array(
            'iOffset' => $iOffset,
            'paginator' => $paginator,
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