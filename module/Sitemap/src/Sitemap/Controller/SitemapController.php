<?php
namespace Sitemap\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SitemapController extends AbstractActionController
{
    
    public function indexAction()
    {
       
        $this->getResponse()->getHeaders()->addHeaderLine(
            'Content-Type', 'text/xml'
        );
       
        
        $aResult = array(
            array(
                'url' => '/'
            ),
            array(
                'url' => '/can-ho-cao-cap'
            ),
            array(
                'url' => '/can-ho-trung-cap'
            ),
        );
        
        $dbAdapter = $this->getServiceLocator()->get('Apartment\Model\ApartmentTable');
        $aApartment = $dbAdapter->getSitemap();
        
        foreach ($aApartment as $item) {
            $aResult[] = array(
                'url' => '/apartment/detail/' . $item['name_url']
            );
        }
        
        /*
        echo "<pre>";
        print_r( $aResult );
        echo "</pre>";
        exit();
        */
        
        /*
        $aConfig = $this->getServiceLocator()->get('config');
        echo "<pre>";
        print_r($aConfig['navigation']);
        echo "</pre>";
        exit;
        */
        
      
        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'aResult' => $aResult
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }
}

?>