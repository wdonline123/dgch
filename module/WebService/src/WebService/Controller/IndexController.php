<?php
namespace WebService\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $aParam = array(
            'Sotai' => '123456',
            'Thoigian' => '12:30',
            'Lat' => '1.23',
            'Lng' => '1.233',
            //'Sotien' => '100000',
            //'Quangduong' => '3',
            'Username' => 'BinhAnh',
            'Password' => 'vdc@binhanh'
        );
        
        
        $oClient = new \SoapClient("http://gateway.vindotcom.vn/ws/binh-anh?wsdl");
        $aResult = $oClient->__soapCall('begin', $aParam);
        
        echo "<pre>";
        print_r($aResult);
        echo "</pre>";
        exit;
    }
}

?>