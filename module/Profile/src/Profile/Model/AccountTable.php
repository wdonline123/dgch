<?php
namespace Profile\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class AccountTable
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
        $aData['isactive'] = 1;
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
    
    public function getDataByEmail($sEmail)
    {
        $rowset = $this->tableGateway->select(array('email' => $sEmail));
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
        $select->from('apartment');
    
        $where = new Where();
        //$where->equalTo('company', $iCompanyId);
        //$where->equalTo('admin', 0);
         
        $select->where($where);
        $select->order('create_date desc');
    
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
        );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
}

?>