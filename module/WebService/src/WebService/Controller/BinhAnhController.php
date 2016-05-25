<?php
namespace WebService\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Soap\AutoDiscover as SoapAutoDiscover;
use Zend\Soap\Server as SoapServer;

class BinhAnhController extends AbstractActionController
{
    
    protected $tbl_adapter;
    
    public function indexAction()
    {
        $sDomain = $this->getRequest()->getServer('HTTP_HOST');
        $sUrl = 'http://' . $sDomain;
        
        $sm = $this->getServiceLocator();
        if ( isset($_GET['wsdl']) ) {
            $autoDiscover = new SoapAutoDiscover();
            $autoDiscover->setClass(new BinhAnh($sm));
            $autoDiscover->setUri($sUrl . '/ws/binh-anh');
            $autoDiscover->handle();
        }
        else {
            $soapServer = new SoapServer(null, array('uri' => $sUrl .'/ws/binh-anh?wsdl'));
            $soapServer->setClass(new BinhAnh($sm));
            $soapServer->handle();
        }
    
        return $this->getResponse();
    }
    
    public function getAdapterTable()
    {
        if (!$this->tbl_adapter) {
            $sm = null;
            //$sm = $this->getServiceLocator();
            //$this->tbl_adapter = $sm->get('Comment\Model\CommentTable');
        }
        return $this->tbl_adapter;
    }
}

?>