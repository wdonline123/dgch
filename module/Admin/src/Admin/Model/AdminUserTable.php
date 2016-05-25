<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class AdminUserTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $arrResult = $this->tableGateway->select(function (Select $select) {
            $select->order('group_id');
        });
        return $arrResult;
    }
    
    public function insert($aData)
    {
        $this->tableGateway->insert($aData);
    }
    
    public function update($id, $aData)
    {
        $this->tableGateway->update($aData, array('id' => $id));
    }
    
    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function getData($id)
    {
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
    }
    
    public function getDataByUsername($sUsername)
    {
        $rowset = $this->tableGateway->select(array('username' => $sUsername));
        $row = $rowset->current();
        return $row;
    }
}

?>