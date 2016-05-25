<?php
namespace WebService\Controller;

class BinhAnh
{
    public $sm;
    
    public $aRequest = array();
    public $oResponse = NULL;
    
    protected $Username = 'BinhAnh';
    protected $Password = 'vdc@binhanh';
    
    const SUCCESS                   = 0;
    const ERROR_USERNAME_PASS       = 1;
    const UNKNOWN                   = 1000;
    
    
    public function __construct($sm) {
        $this->sm = $sm;
    }
    
    /**
     * Start charging 
     * 
     * @param string $Sotai
     * @param string $Thoigian
     * @param string $Lat
     * @param string $Lng   
     * @param string $Username
     * @param string $Password
     * 
     * @return array
     * 
     */
    public function begin($Sotai, $Thoigian, $Lat, $Lng, $Username, $Password)
    {
        $this->aRequest['sotai']        = $Sotai;
        $this->aRequest['thoigian']     = $Thoigian;
        $this->aRequest['lat']          = $Lat;
        $this->aRequest['lng']          = $Lng;
        
        $iResponse = $this->validate($Username, $Password);
        
        return $this->response($iResponse);
    }
    
    
    /**
     * Total charging
     * 
     * @param string $Sotai
     * @param string $Thoigian
     * @param string $Lat
     * @param string $Lng
     * @param string $Sotien
     * @param string $Quangduong
     * @param string $Username
     * @param string $Password
     * 
     * @return array
     * 
     */
    public function finish($Sotai, $Thoigian, $Lat, $Lng, $Sotien, $Quangduong, $Username, $Password)
    {
        $this->aRequest['sotai']            = $Sotai;
        $this->aRequest['thoigian']         = $Thoigian;
        $this->aRequest['lat']              = $Lat;
        $this->aRequest['lng']              = $Lng;
        $this->aRequest['sotien']           = $Sotien;
        $this->aRequest['quangduong']       = $Quangduong;
        
        $iResponse = $this->validate($Username, $Password);
        
        return $this->response($iResponse);
    }
    
    protected function validate($Username, $Password)
    {
        $iResponse = self::SUCCESS;
        if ( $Username != $this->Username || $Password != $this->Password ) {
            $iResponse = self::ERROR_USERNAME_PASS;
        }
        
        return $iResponse;
    }
    
    public function response($iResponse)
    {
        $sErrorDesc = '';
        if ($iResponse == self::SUCCESS) { // 0
            $sErrorDesc = 'Success';
        }
        elseif ($iResponse == self::ERROR_USERNAME_PASS) {  // 1
            $sErrorDesc = 'Invalid Username/Password';
        }
        else {
            $iResponse = self::UNKNOWN;
            $sErrorDesc = 'UNKNOWN';
        }
    
        $aResponse = array(
            'resp_id' => $iResponse,
            'resp_des' => $sErrorDesc,
        );
        return $aResponse;
    }
    
   
}

?>