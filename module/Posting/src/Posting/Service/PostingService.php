<?php
namespace Posting\Service;

class PostingService
{
    public function getType()
    {
        return array(
            '1' => 'Bán căn hộ',
            '2' => 'Cho thuê căn hộ',
            '3' => 'Mua căn hộ',
            '4' => 'Thuê căn hộ'
        );
    }
    
    public function getPrice($iType)
    {
        $aResult = array();
        
        if ( $iType == 1 ) {
            $aResult = array(
                '0' => 'Thỏa thuận',
                '1' => 'Tỷ',
                '2' => 'Trăm triệu',
            );
        }
        elseif ( $iType == 2 ) {
            $aResult = array(
                '0' => 'Thỏa thuận',
                '1' => 'Triệu/tháng',
            );
        }
        elseif ( $iType == 3 ) {
            $aResult = array(
                '0' => 'Thỏa thuận',
                '1' => 'Tỷ',
                '2' => 'Trăm triệu',
            );
        }
        elseif ( $iType == 4 ) {
            $aResult = array(
                '0' => 'Thỏa thuận',
                '1' => 'Triệu/tháng',
            );
        }
        
        return $aResult;
    }
}

?>