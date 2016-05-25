<?php
namespace Apartment\Controller;

use Application\Controller\FrontEnd;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends FrontEnd 
{
    protected $tbl_adapter;
    
    public function indexAction()
    {
        echo 222;
        exit();
    }
    
    public function detailAction()
    {
        $sNameUrl = $this->params()->fromRoute('name-url');
        
        $infoApartment = $this->getAdapterTable()->getDataByNameUrl($sNameUrl);
        
        $aPicture = array();
        $aComment = array();
        if ( isset($infoApartment['id']) ) {
            $aPicture = $this->getPicture($infoApartment['folder']);
            $this->updateView($infoApartment['id']);
            $aComment = $this->getParentComment($infoApartment['id']);
        }
        
        $this->layout()->sHeaderTitle = $infoApartment['name'];
        $this->layout()->sSiteDescription = 'Thông tin và những chia sẽ của khách hàng về căn hộ '. $infoApartment['name'];
        $this->layout()->sSiteKeywords = $infoApartment['name'];
        
        return new ViewModel(array(
            'infoAccount'       => $this->infoAccount,
            'aLocation'         => $this->getOptionLocation(),
            'infoApartment'     => $infoApartment,
            'aComment'          => $aComment,
            'aPicture'          => $aPicture,
        ));
    }
    
    public function getParentComment($iApartmentId)
    {
        $dbAdapter = $this->getServiceLocator()->get('Comment\Model\CommentTable');
        return $dbAdapter->getListParent($iApartmentId, 1);
    }
    
    public function mostViewAction()
    {
        $aResult = $this->getAdapterTable()->getMostView();
        
        return new JsonModel($aResult);
    }
    
    public function optionAction()
    {
        $aFilter = array(
            'city_id' => $this->params()->fromQuery('city_id', 0),
            'district_id' => $this->params()->fromQuery('district_id', 0)
        );
        
        $aResult = array();
        if ($aFilter['city_id'] > 0 && $aFilter['district_id'] > 0) {
            $aResult = $this->getAdapterTable()->getOption($aFilter);
        }
        return new JsonModel($aResult);
    }
    
    protected function getPicture($sFolder)
    {
        $aFile = array();
        if ( !empty($sFolder) ) {
            $sPath = $_SERVER['DOCUMENT_ROOT'] .'/public'. $sFolder;
            
            if ( is_dir($sPath) ) {
                $aScan = @scandir($sPath);
                $aFile = array();
                foreach($aScan as $key => $value) {
                    if ( !in_array($value, array(".","..")) ) {
                        if( !is_dir($sPath . DIRECTORY_SEPARATOR . $value) ) {
                            $aFile[] = $sFolder .'/'. $value;
                        }
                    }
                }
            }
        }
        return $aFile;
    }
    
    protected function updateView($id)
    {
        $aData = array(
            'number_view' => new \Zend\Db\Sql\Expression("number_view + 1"),
        );
        $this->getAdapterTable()->update($id, $aData);
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