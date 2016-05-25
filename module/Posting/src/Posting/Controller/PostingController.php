<?php
namespace Posting\Controller;

use Application\Controller\FrontEnd;
use Zend\View\Model\ViewModel;

class PostingController extends FrontEnd
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        $aFilter = array(
           'type' => (int)$this->params()->fromQuery('type', 0),
        );
        
        $iLimit = 10;
        $iPage = (int)$this->params()->fromQuery('page', 1);
        $iOffset = ($iPage - 1) * $iLimit;
         
        $aPosting = $this->getAdapterTable()->getList($aFilter);
        $aPosting->setCurrentPageNumber($iPage);
        $aPosting->setItemCountPerPage($iLimit);
        
        return new ViewModel(array(
            'aPosting'         => $aPosting,
        ));
    }
    
    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');
        $infoPosting = $this->getAdapterTable()->getData($id);
        
        return new ViewModel(array(
            'infoPosting'         => $infoPosting,
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