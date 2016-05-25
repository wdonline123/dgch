<?php
namespace Apartment\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Crypt\PublicKey\Rsa\PublicKey;

class ApartmentTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function insert($aData)
    {
        $aData['create_date'] = date("Y-m-d H:i:s");
        $aData['modify_date'] = date("Y-m-d H:i:s");
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
    
    public function getDataByNameUrl($sNameUrl)
    {
        $rowset = $this->tableGateway->select(array('name_url' => $sNameUrl));
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
            array('id', 'name', 'picture', 'isactive', 'number_view', 'number_like', 'number_comment',
                'city_id', 'district_id', 'create_date', 'modify_date', 'position', 'min_price', 'max_price',
                'price', 'type'
            )
        );
        $select->from('apartment');
    
        $where = new Where();
       // $where->equalTo('company', $iCompanyId);
        //$where->equalTo('admin', 0);
         
        /*
        if ( (int)$aSearch['agency_id'] > 0 ) {
            $where->equalTo('id', (int)$aSearch['7 028. 0 ']);
        }
        if ( !empty($aSearch['fullname']) ) {
            $where->like('fullname', '%'.$aSearch['fullname'].'%');
        }
        if ( !empty($aSearch['username']) ) {
            $where->equalTo('username', $aSearch['username']);
        }
        if ( $aSearch['status'] > -1 ) {
            $where->equalTo('status', $aSearch['status']);
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
    
    public function getList($aSearch)
    {
        $select = new Select();
        $select->columns(
            array('id', 'name', 'picture', 'isactive', 'number_view', 'number_like', 'number_comment',
                'city_id', 'district_id', 'create_date', 'modify_date', 'position', 'min_price', 'max_price',
                'url', 'price', 'type'
            )
        );
        $select->from('apartment');
        
        $where = new Where();
        $where->equalTo('isactive', 1);
        
        if ( !empty($aSearch['keyword']) ) {
            $where->like('name', '%'. $aSearch['keyword'] .'%');
        }
        
        if ( isset($aSearch['city_id']) && (int)$aSearch['city_id'] > 0 ) {
            $where->equalTo('city_id', (int)$aSearch['city_id']);
        }
        if ( isset($aSearch['district_id']) && (int)$aSearch['district_id'] > 0 ) {
            $where->equalTo('district_id', (int)$aSearch['district_id']);
        }
        if ( isset($aSearch['type']) && (int)$aSearch['type'] > 0 ) {
            $where->equalTo('type', (int)$aSearch['type']);
        }
        
        $select->where($where);
        $select->order('create_date desc');
        
        //echo $select->getSqlString();
        //exit();
        
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
        );
        
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    public function getMostView()
    {
        $aResult = $this->tableGateway->select(function (Select $select) {
            $select->columns(
                array('id', 'name', 'picture', 'url', 'price')
            );
            $select->where(
                array('isactive' => 1)
            );
            $select->order('number_view DESC');
            $select->limit(10);
        });
        return $aResult;
    }
    
    public function getOption($aFilter)
    {
        $aResult = $this->tableGateway->select(function (Select $select) use ($aFilter) {
            $select->columns(
                array('id', 'name', 'picture', 'url', 'price', 'position')
            );
            $select->where(array(
                'isactive' => 1,
                'city_id' => $aFilter['city_id'],
                'district_id' => $aFilter['district_id'],
            ));
            $select->order('name');
            $select->limit(100);
        });
        return $aResult->toArray();
    }
    
    public function getSitemap()
    {
        $aResult = $this->tableGateway->select(function (Select $select) {
            $select->columns(
                array('id', 'name', 'name_url')
            );
            $select->where->equalTo('isactive', 1);
            $select->order('create_date desc');
        });
        return $aResult;
    }
}

?>