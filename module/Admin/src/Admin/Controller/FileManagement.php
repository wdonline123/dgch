<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class FileManagement extends BackEndController
{
    protected $sBaseUrl;
    protected $sRootPath;
    
    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function uploadAction()
    {
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aData = $oRequest->getPost()->toArray();
            $aFile =  $oRequest->getFiles()->toArray();
            $sPath = $this->getRootPath();
    
            $sUploadFile = '';
            $sFileName = $aFile['picture']['name'];
    
            $oUpload     = new \Zend\File\Transfer\Adapter\Http();
            $filesize    = new \Zend\Validator\File\Size(array('min' => '1kb', 'max' => '1MB'));
            $extension   = new \Zend\Validator\File\Extension(array('extension' => array('jpeg', 'jpg', 'gif', 'png')));
    
            $oUpload->setValidators(array($filesize, $extension), $sFileName);
    
            if( $oUpload->isValid() ) {
                if ( !empty($aData['current_folder']) ) {
                    $sPath = $sPath . DIRECTORY_SEPARATOR . $aData['current_folder'];
                }
    
                $oUpload->setDestination($sPath);
                if( $oUpload->receive($sFileName) ) {
                    $sUploadFile = $oUpload->getFileName(null, false);
                }
    
            } else {
                $aError = $oUpload->getMessages();
                echo "<pre>";
                print_r($aError);
                echo "</pre>";
            }
            echo $sUploadFile;
        }
        exit;
    }
    
    public function createFolderAction()
    {
        $sPath = $this->getRootPath();
        $oRequest = $this->getRequest();
        if ( $oRequest->isPost() ) {
            $aData = $oRequest->getPost()->toArray();
            if ( !empty($aData['current_folder']) ) {
                $sPath = $sPath . DIRECTORY_SEPARATOR . $aData['current_folder'];
            }
            if ( !empty($aData['folder_name']) ) {
                $sPath = $sPath . DIRECTORY_SEPARATOR . $aData['folder_name'];
            }
            @mkdir($sPath, 0777);
            echo $sPath;
        }
        exit;
    }
    
    public function contentAction()
    {
        $sFolder = $this->params()->fromQuery('folder', '');
        $sPath = $this->getRootPath();
        if ( !empty($sFolder) ) {
            $sFolder = str_replace('/' , DIRECTORY_SEPARATOR, $sFolder);
            $sRealPath = realpath($sPath);
            $sRealPathFolder = realpath($sPath . DIRECTORY_SEPARATOR . $sFolder);
            if ( $sRealPath != $sRealPathFolder ) {
                $sFolder = str_replace($sRealPath . DIRECTORY_SEPARATOR, '', $sRealPathFolder);
                $sPath = $sPath . DIRECTORY_SEPARATOR . $sFolder;
            }
            else {
                $sFolder = '';
            }
        }
        $aScan = scandir($sPath);
        $sFolder = str_replace(DIRECTORY_SEPARATOR, '/', $sFolder);
    
        $aFile = $aFolder = array();
        foreach($aScan as $key => $value) {
            if ( !in_array($value, array(".","..")) ) {
                if( is_dir($sPath . DIRECTORY_SEPARATOR . $value) ) {
                    $aFolder[] = $value;
                } else {
                    if ( !empty($sFolder) ) {
                        
                        
                        $aFile[] = $this->getBaseUrl() .'/'. $sFolder .'/'. $value;
                    }
                    else {
                        $aFile[] = $this->getBaseUrl() .'/'. $value;
                    }
                }
            }
        }
    
        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'sFolder' => $sFolder,
            'aFile' => $aFile,
            'aFolder' => $aFolder
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    protected function getRootPath()
    {
        if (!$this->sRootPath) {    
            $sPath = $_SERVER['DOCUMENT_ROOT'] . '/public/upload';
            //$sPath = $sPath . DIRECTORY_SEPARATOR . 'upload';
    
            if ( !is_dir($sPath) ) {
                mkdir($sPath, 0777, true);
            }
            $this->sRootPath = $sPath;
        }
        return $this->sRootPath;
    }
    
    protected function getBaseUrl()
    {
        if (!$this->sBaseUrl) {    
            $sBaseUrl = '/upload';
            $this->sBaseUrl = $sBaseUrl;
        }
        return $this->sBaseUrl;
    }
}

?>