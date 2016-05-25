<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class LocationTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function insert($aData)
    {
        $this->tableGateway->insert($aData);
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
    
    public function fetchAll()
    {
        $aResult = $this->tableGateway->select(function (Select $select) {
            $select->order('parent ASC, id ASC');  
        });
        return $aResult;
    }
    
    public function getListAdmin($iParent)
    {
        $aResult = $this->tableGateway->select(function (Select $select) use ($iParent) {
            $select->where->equalTo('parent', $iParent);
            $select->order('parent ASC, id ASC');
        });
        return $aResult;
    }
    
    public function getList($iParent)
    {
        $aResult = $this->tableGateway->select(function (Select $select) use ($iParent) {
            $select->where->equalTo('isactive', 1);
            $select->where->equalTo('parent', $iParent);
            $select->order('parent ASC, id ASC'); 
        });
        return $aResult;
    }
}

?>