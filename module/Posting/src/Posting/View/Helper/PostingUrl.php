<?php
namespace Posting\View\Helper;

use Zend\View\Helper\AbstractHelper;

class PostingUrl extends AbstractHelper
{
    public function __invoke($id, $sTitle)
    {
        $sResult = '/posting/detail/'. $id .'/'. $this->convertTitleURL($sTitle);
        return $sResult;
    }
    
    protected function convertTitleURL($sText = '') {
        $sText = trim(mb_strtolower($sText, 'utf-8'));
        $char_unicode = array(
            '#ạ|á|à|ả|ã|â|ậ|ấ|ầ|ẩ|ẫ|ă|ặ|ắ|ằ|ẳ|ẫ#i',
            '#ê|ẹ|é|è|ẻ|ẽ|ế|ề|ể|ễ|ệ#i',
            '#ọ|ộ|ổ|ỗ|ố|ồ|ô|ó|ò|ỏ|õ|ơ|ợ|ớ|ờ|ở|ỡ#i',
            '#ụ|ư|ứ|ừ|ử|ữ|ự|ú|ù|ủ|ũ#i',
            '#ị|í|ì|ỉ|ĩ#i',
            '#ỵ|ý|ỳ|ỷ|ỹ#i',
            '#đ#i',
            '#[^a-zA-Z0-9\s]#i',
            '#[\s]#i'
        );
        $char_EN = array( 'a','e','o','u','i','y','d','','-');
        $sText = preg_replace($char_unicode, $char_EN, $sText);
        return str_replace('--', '-', $sText);
    }
}

?>