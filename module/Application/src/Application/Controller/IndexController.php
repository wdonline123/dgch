<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Profile\Form\AccountForm;

class IndexController extends FrontEnd
{
    public function indexAction()
    {
        $aSearch = array(
            'keyword'       => $this->params()->fromQuery('keyword'),
            'city_id'       => (int)$this->params()->fromQuery('city_id', 0),
            'district_id'   => (int)$this->params()->fromQuery('district_id', 0),
        );
        
        $iLimit = 10;
        $iPage = (int)$this->params()->fromQuery('page', 1);
        $iOffset = ($iPage - 1) * $iLimit;
        
        $this->layout()->sSitePage = 'home';
        $this->layout()->sSiteDescription = 'Định giá căn hộ - Cập nhật thông tin các dự án căn hộ, những chia sẽ của khách hàng với giá tốt nhất hiện nay cùng với những ưu đãi hấp dẫn';
        $this->layout()->sSiteKeywords = 'dinhgiacanho,định giá căn hộ,định giá chung cư,định giá,căn hộ,chung cư,nhà ở,nhà đất,bất động sản';
        
        return new ViewModel(array(
            'aSearch'       => $aSearch,
            'paginator'     => $this->getDataApartment($iPage, $iLimit, $aSearch)
        ));
    }
    
    public function vipAction()
    {
        $aSearch = array(
            'type' => 1
        );
        
        $iLimit = 10;
        $iPage = (int)$this->params()->fromQuery('page', 1);
        $iOffset = ($iPage - 1) * $iLimit;
        
        $this->layout()->menu = 'vip';
        $this->layout()->sHeaderTitle = 'Căn hộ cao cấp';
        $this->layout()->sSiteDescription = 'Căn hộ cao cấp - cập nhật thông tin các dự án căn hộ cao cấp với giá tốt nhất hiện nay cùng với những ưu đãi hấp dẫn';
        $this->layout()->sSiteKeywords = 'căn hộ cao cấp, định giá căn hộ';
        
        return new ViewModel(array(
            'aSearch' => $aSearch,
            'paginator' => $this->getDataApartment($iPage, $iLimit, $aSearch)
        ));
    }
    
    public function intermediateAction()
    {
        $aSearch = array(
            'type' => 2
        );
        
        $iLimit = 10;
        $iPage = (int)$this->params()->fromQuery('page', 1);
        $iOffset = ($iPage - 1) * $iLimit;
        
        $this->layout()->menu = 'intermediate';
        $this->layout()->sHeaderTitle = 'Căn hộ trung cấp';
        $this->layout()->sSiteDescription = 'Căn hộ trung cấp - cập nhật thông tin các dự án căn hộ với giá tốt nhất hiện nay cùng với những ưu đãi hấp dẫn';
        $this->layout()->sSiteKeywords = 'căn hộ trung cấp, căn hộ phổ thông, định giá căn hộ';
        
        return new ViewModel(array(
            'aSearch' => $aSearch,
            'paginator' => $this->getDataApartment($iPage, $iLimit, $aSearch)
        ));
    }
    
    public function commonAction()
    {
        $aSearch = array(
            'type' => 3
        );
        
        $iLimit = 10;
        $iPage = (int)$this->params()->fromQuery('page', 1);
        $iOffset = ($iPage - 1) * $iLimit;
        
        $this->layout()->menu = 'common';
        $this->layout()->sHeaderTitle = 'Căn hộ phổ thông';
        return new ViewModel(array(
            'paginator' => $this->getDataApartment($iPage, $iLimit, $aSearch)
        ));
    }
    
    public function introduceAction()
    {
        $this->layout()->sHeaderTitle = 'Giới thiệu';
    }
    
    public function privacyAction()
    {
        $this->layout()->sHeaderTitle = 'Quyền riêng tư';
    }
    
    public function termsAction()
    {
        $this->layout()->sHeaderTitle = 'Điều khoản';
    }
    
    public function loginAction()
    {
        $oRequest = $this->getRequest();
        if ( $oRequest->isPost() ){
            $oAuth = $this->getServiceLocator()->get('AuthServiceFront');
            $oAuth->getAdapter()
                        ->setIdentity($oRequest->getPost('email'))
                        ->setCredential($oRequest->getPost('password'));
             
            $oResult = $oAuth->authenticate();
        
            if ( $oResult->isValid() ) {
                $oAuth->getStorage()->write($oRequest->getPost('email'));
                
                $sUri = $this->params()->fromQuery('back_url');
                if ( !empty($sUri) ) {
                    return $this->redirect()->toUrl( urldecode($sUri) );
                }
                else {
                    return $this->redirect()->toRoute('home');
                }
            }
            else {
                $this->layout()->error = "Đăng nhập thất bại";
            }
        }
        
        $this->layout()->sHeaderTitle = 'Đăng nhập';
    }
    
    public function registerAction()
    {
        $aOption = array();
        $oForm = new AccountForm('frmAdd', $aOption);
        
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $oForm->addValidate();
            $oForm->setData($oRequest->getPost());
        
            if ( $oForm->isValid() ) {
                $aData = $oForm->getData();
                $aData['password'] = md5($aData['password']);
                $dbAdapter = $this->getServiceLocator()->get('Profile\Model\AccountTable');
                $dbAdapter->insert($aData);
                return $this->redirect()->toRoute('login');
            }
        }
        
        $this->layout()->sHeaderTitle = 'Đăng ký';
        return new ViewModel(array(
            'oForm' => $oForm,
        ));
    }
    
    public function logoutAction()
    {
        $this->getServiceLocator()->get('AuthServiceFront')->clearIdentity();    
        return $this->redirect()->toRoute('home');
    }
    
    protected function getDataApartment($iPage, $iLimit, $aSearch)
    {
        $dbAdapterApartment = $this->getServiceLocator()->get('Apartment\Model\ApartmentTable');
         
        $paginator = $dbAdapterApartment->getList($aSearch);
        $paginator->setCurrentPageNumber($iPage);
        $paginator->setItemCountPerPage($iLimit);
        
        return $paginator;
    }
}
