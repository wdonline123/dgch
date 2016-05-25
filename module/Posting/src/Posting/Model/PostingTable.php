<?php
namespace Posting\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Validator\Explode;

class PostingTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function insert($aData)
    {
        $aData['create_date']   = date("Y-m-d H:i:s");
        $aData['modify_date']   = date("Y-m-d H:i:s");
        $this->tableGateway->insert($aData);
        return $this->tableGateway->lastInsertValue;
    }
    
    public function update($id, $aData)
    {
        
        $this->tableGateway->update($aData, array('id' => $id));
    }
    
    public function getData($id)
    {
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
    }
    
    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function getListAdmin($aSearch)
    {
        $select = new Select();
        $select->columns(
            array('id', 'title', 'picture', 'price', 'price_unit', 'acreage', 'category_id', 'category_parent',
                'status', 'user_id',
                'start_date', 'end_date', 'create_date', 'modify_date', 'public_date',
                'contact_name', 'contact_email', 'type_ad'
            )
            );
        $select->from('posting');
    
        $where = new Where();
    
        if ( isset($aSearch['category_parent']) && (int)$aSearch['category_parent'] > 0 ) {
            $where->equalTo('category_parent', (int)$aSearch['category_parent']);
        }
        if ( isset($aSearch['category_id']) && (int)$aSearch['category_id'] > 0 ) {
            $where->equalTo('category_id', (int)$aSearch['category_id']);
        }
        if ( isset($aSearch['status']) && (int)$aSearch['status'] > -1 ) {
            $where->equalTo('status', (int)$aSearch['status']);
        }
        if ( isset($aSearch['city_id']) && (int)$aSearch['city_id'] > 0 ) {
            $where->equalTo('city_id', (int)$aSearch['city_id']);
        }
        if ( isset($aSearch['district_id']) && (int)$aSearch['district_id'] > 0 ) {
            $where->equalTo('district_id', (int)$aSearch['district_id']);
        }
        if ( isset($aSearch['type_ad']) && (int)$aSearch['type_ad'] > 0 ) {
            $where->equalTo('type_ad', (int)$aSearch['type_ad']);
        }
    
        $select->where($where);
        $select->order('create_date desc');
    
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
            );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    
   
    
    public function search($aSearch)
    {
        $select = new Select();
        $select->columns(array(
            'id', 'title', 'picture', 'price', 'price_unit', 'acreage', 'information',
            'address', 'city_id', 'district_id', 'start_date', 'end_date',
            'type_ad', 'public_date'
        ));
        $select->from('posting');
    
        $where = new Where();
        $where->equalTo('status', 2);
    
        if ( !empty($aSearch['keyword']) ) {
            if ( is_numeric($aSearch['keyword']) ) {
                $where->equalTo('id', $aSearch['keyword']);
            }
            else {
                $where->like('title', '%'. $aSearch['keyword'] .'%');
            }
        }
    
        if ( isset($aSearch['category_parent']) && (int)$aSearch['category_parent'] > 0 ) {
            $where->equalTo('category_parent', (int)$aSearch['category_parent']);
        }
        if ( isset($aSearch['category_id']) && (int)$aSearch['category_id'] > 0 ) {
            $where->equalTo('category_id', (int)$aSearch['category_id']);
        }
        if ( isset($aSearch['type_ad']) && (int)$aSearch['type_ad'] > 0 ) {
            $where->equalTo('type_ad', (int)$aSearch['type_ad']);
        }
        if ( isset($aSearch['city_id']) && (int)$aSearch['city_id'] > 0 ) {
            $where->equalTo('city_id', (int)$aSearch['city_id']);
        }
        if ( isset($aSearch['district_id']) && (int)$aSearch['district_id'] > 0 ) {
            $where->equalTo('district_id', (int)$aSearch['district_id']);
        }
        if ( isset($aSearch['ward_id']) && (int)$aSearch['ward_id'] > 0 ) {
            $where->equalTo('ward_id', (int)$aSearch['ward_id']);
        }
        if ( isset($aSearch['street_id']) && (int)$aSearch['street_id'] > 0 ) {
            $where->equalTo('street_id', (int)$aSearch['street_id']);
        }
    
        if ( !empty($aSearch['area_level']) ) {
            $where->between('acreage', $aSearch['area_from'], $aSearch['area_to']);
        }
    
        if ( !empty($aSearch['price_level']) ) {
            if ( $aSearch['price_level'] == '-' ) {
                $where->equalTo('price_unit', 0);
            }
            else {
                $where->between('price_total', $aSearch['price_from'], $aSearch['price_to']);
            }
        }
    
        if ( isset($aSearch['direct_home']) && (int)$aSearch['direct_home'] > 0 ) {
            $where->equalTo('direct_home', (int)$aSearch['direct_home']);
        }
        if ( isset($aSearch['direct_balcony']) && (int)$aSearch['direct_balcony'] > 0 ) {
            $where->equalTo('direct_balcony', (int)$aSearch['direct_balcony']);
        }
         
        $select->where($where);
        $select->order('order_date desc');
    
        //echo $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
        //exit;
    
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
            );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    public function getListByAccount($aSearch)
    {
        $select = new Select();
        $select->columns(array(
            'id', 'title', 
            'status', 
            'create_date'
        ));
        $select->from('posting');
    
        $where = new Where();
        $where->equalTo('account_id', $aSearch['account_id']);
    
        /*
        if ( $aSearch['category_id'] > 0 ) {
            $where->equalTo('category_id', $aSearch['category_id']);
        }
        if ( $aSearch['posting_id'] > 0 ) {
            $where->equalTo('id', $aSearch['posting_id']);
        }
        if ( $aSearch['type_ad'] > 0 ) {
            $where->equalTo('type_ad', $aSearch['type_ad']);
        }
        */
         
        $select->where($where);
        $select->order('create_date desc');
    
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
            );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    public function getList($aFilter)
    {
        $select = new Select();
        $select->columns(array(
            'id', 'title', 
        ));
        $select->from('posting');
    
        $where = new Where();
        //$where->equalTo('status', 2);
        
        if ( isset($aSearch['type']) && (int)$aSearch['type'] > 0 ) {
            $where->equalTo('type', (int)$aSearch['type']);
        }
        /*
        if ( isset($aSearch['category_id']) && (int)$aSearch['category_id'] > 0 ) {
            $where->equalTo('category_id', (int)$aSearch['category_id']);
        }
        if ( isset($aSearch['type_ad']) && (int)$aSearch['type_ad'] > 0 ) {
            $where->equalTo('type_ad', (int)$aSearch['type_ad']);
        }
        */
    
        $select->where($where);
        $select->order('create_date desc');
    
        //echo $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
        //exit;
    
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
        );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    public function getHomePage($aSearch)
    {
        $select = new Select();
        $select->columns(array(
            'id', 'title', 'picture', 'price', 'price_unit', 'acreage', 'information',
            'address', 'city_id', 'district_id', 'start_date', 'end_date',
            'type_ad', 'public_date'
        ));
        $select->from('posting');
    
        $where = new Where();
        $where->equalTo('status', 2);
    
        if ( isset($aSearch['category_parent']) && (int)$aSearch['category_parent'] > 0 ) {
            $where->equalTo('category_parent', (int)$aSearch['category_parent']);
        }
        if ( isset($aSearch['category_id']) && (int)$aSearch['category_id'] > 0 ) {
            $where->equalTo('category_id', (int)$aSearch['category_id']);
        }
        if ( isset($aSearch['type_ad']) && (int)$aSearch['type_ad'] > 0 ) {
            $where->equalTo('type_ad', (int)$aSearch['type_ad']);
        }
        if ( isset($aSearch['video']) && (int)$aSearch['video'] == 1 ) {
            //$where->isNotNull('youtube_url');
            $where->notEqualTo('youtube_url', '');
        }
    
        $select->where($where);
        $select->order('order_date desc');
    
        //echo $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
        //exit;
    
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
            );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    public function getListRelation($aSearch)
    {
        $select = new Select();
        $select->columns(array(
            'id', 'title', 'picture', 'price', 'price_unit', 'acreage', 'information', 'address',
            'start_date', 'end_date', 'type_ad', 'public_date'
        ));
        $select->from('posting');
    
        $where = new Where();
        $where->equalTo('status', 2);
        $where->notEqualTo('id', $aSearch['id']);
    
        if ($aSearch['street_id'] > 0) {
            $where->equalTo('street_id', $aSearch['street_id']);
        }
        elseif ($aSearch['district_id'] > 0) {
            $where->equalTo('district_id', $aSearch['district_id']);
        }
        else {
            $where->equalTo('category_id', $aSearch['category_id']);
        }
    
        if ( !empty($aSearch['price_level']) ) {
            if ( $aSearch['price_level'] == '-' ) {
                $where->equalTo('price_unit', 0);
            }
            else {
                if ( (int)$aSearch['price_from'] == 0 ) {
                    $where->greaterThan('price_total', 0);
                }
                $where->between('price_total', $aSearch['price_from'], $aSearch['price_to']);
            }
        }
    
        $select->where($where);
        $select->order('order_date DESC');
    
        /*
         echo $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
         exit;
         */
    
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
            );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    public function getLucene($aSearch)
    {
        $aResult = $this->tableGateway->select(function (Select $select) use ($aSearch) {
            $select->columns(array(
                'id', 'title', 'address',
                'picture', 'price', 'price_unit', 'acreage', 'information',
                'city_id', 'district_id', 'start_date', 'end_date',
            ));
            $select->where->equalTo('status', 2);
            /*
             if ( isset($aSearch['type_ad']) && $aSearch['type_ad'] > 0 ) {
             $select->where->equalTo('type_ad', $aSearch['type_ad']);
             }
             if ( isset($aSearch['category_parent']) && $aSearch['category_parent'] > 0 ) {
             $select->where->equalTo('category_parent', $aSearch['category_parent']);
             }
             if ( isset($aSearch['category_id']) && $aSearch['category_id'] > 0 ) {
             $select->where->equalTo('category_id', $aSearch['category_id']);
             }
             */
            $select->order('create_date DESC');
            $select->limit(100);
            //echo $select->getSqlString();
        });
            return $aResult;
    }
    
    private function convertDate($sDate)
    {
        $sResult = '';
        if ( !empty($sDate) ) {
            $aDate = explode("-", $sDate);
            $sResult = $aDate[2] ."-". $aDate[1] ."-". $aDate[0];
        }
        return $sResult;
    }
}

?>