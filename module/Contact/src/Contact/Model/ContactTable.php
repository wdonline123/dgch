<?php
namespace Contact\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ContactTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function insert($aData)
    {
        $aData['create_date'] = date("Y-m-d H:i:s");
        $this->tableGateway->insert($aData);
        return $this->tableGateway->lastInsertValue;
    }
    
    public function update($id, $aData)
    {
        $this->tableGateway->update($aData, array('comment_id' => $id));
    }
    
    public function getData($id)
    {
        $rowset = $this->tableGateway->select(array('comment_id' => $id));
        $row = $rowset->current();
        return $row;
    }
    
    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function getListAdmin()
    {
        $select = new Select();
        $select->from('contacts');
        $select->order('create_date desc');
    
        // create a new pagination adapter object
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
        );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
}

?>