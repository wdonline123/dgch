<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class AdminGroupTable 
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $arrResult = $this->tableGateway->select(function (Select $select) {
            $select->order('group_name');
        });
        return $arrResult;
    }
    
    public function insert($aData)
    {
        $this->tableGateway->insert($aData);
    }
    
    public function update($id, $aData)
    {
        $this->tableGateway->update($aData, array('group_id' => $id));
    }
    
    public function delete($id)
    {
        $this->tableGateway->delete(array('group_id' => $id));
    }
    
    public function getData($id)
    {
        $rowset = $this->tableGateway->select(array('group_id' => $id));
        $row = $rowset->current();
        return $row;
    }
    
    
}

?>