<?php
namespace Like\Controller;

use Application\Controller\FrontEnd;
use Zend\Json\Json;

class LikeController extends FrontEnd
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        /*
        $arrResult = array();
        $objRequest = $this->getRequest();
        if ($objRequest->isPost())
        {
            $arrData = $objRequest->getPost()->toArray();
            $arrResult = $this->getAdapterTable()->getListMember($arrData['object_id'], $arrData['comment_id'], $arrData['object_type']);
        }
        return $this->getResponse()->setContent(Json::encode($arrResult));
        */
    }
    
    public function addAction()
    {
        $aResult = array();
        if ( isset($this->infoAccount['account_id']) ) {
            $oRequest = $this->getRequest();
            if ( $oRequest->isPost() ) {
                $aData = $oRequest->getPost()->toArray();
                
                $aData['account_id']    = $this->infoAccount['account_id'];
                $aData['fullname'] 		= $this->infoAccount['fullname'];
                $aData['avatar'] 	    = $this->infoAccount['avatar'];
                
                $infoLike = $this->getAdapterTable()->getDataByObject($aData);
                if ( isset($infoLike['like_id']) ) {
                    $this->getAdapterTable()->delete($infoLike['like_id']);
                    if ($aData['object_type'] == 1) {
                        $aDataApartment = array(
                            'number_like' => new \Zend\Db\Sql\Expression("number_like - 1"),
                        );
                        
                        $dbAdapterApartment = $this->getServiceLocator()->get('Apartment\Model\ApartmentTable');
                        $dbAdapterApartment->update($aData['object_id'], $aDataApartment);
                        $infoApartment = $dbAdapterApartment->getData($aData['object_id']);
                        $aResult = array(
                            'number_like' => $infoApartment['number_like'],
                            'label_like' => 'Like',
                        );
                        
                    }
                        
                    
                }
                else {
                    $id = $this->getAdapterTable()->insert($aData);
                    if ($aData['object_type'] == 1) {
                        $aDataApartment = array(
                            'number_like' => new \Zend\Db\Sql\Expression("number_like + 1"),
                        );
                          
                        $dbAdapterApartment = $this->getServiceLocator()->get('Apartment\Model\ApartmentTable');
                        $dbAdapterApartment->update($aData['object_id'], $aDataApartment);
                        $infoArticle = $dbAdapterApartment->getData($aData['object_id']);
                        $infoApartment = $dbAdapterApartment->getData($aData['object_id']);
                        $aResult = array(
                            'number_like' => $infoApartment['number_like'],
                            'label_like' => 'Like',
                        );
                    }
                    
                }
                
            }
        }
        
        return $this->getResponse()->setContent(Json::encode($aResult));
    }
    
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = $this->getServiceLocator();
            $this->tbl_adapter = $sm->get('Like\Model\LikeTable');
        }
        return $this->tbl_adapter;
    }
}

?>