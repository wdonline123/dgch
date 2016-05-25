<?php
namespace Admin\Controller;

class IndexController extends BackEndController
{
    public function indexAction()
    {
        
    }
    
    public function loginAction()
    {
        $oRequest = $this->getRequest();
        if ( $oRequest->isPost() ){
            $oAuth = $this->getServiceLocator()->get('AuthServiceBackEnd');
            $oAuth->getAdapter()
                        ->setIdentity($oRequest->getPost('username'))
                        ->setCredential($oRequest->getPost('password'));
             
            $oResult = $oAuth->authenticate();
        
            if ( $oResult->isValid() ) {
                $oAuth->getStorage()->write($oRequest->getPost('username'));
                return $this->redirect()->toRoute('admin');
            }
            else {
                $this->layout()->error = "Đăng nhập thất bại";
            }
        }
        
        $this->layout()->setTemplate('admin/index/login.phtml');
    }
    
    public function logoutAction()
    {
        
    }
    
    public function changePasswordAction()
    {
        
    }
}

?>