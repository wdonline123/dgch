<?php
namespace Comment\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CommentTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function insert($aData)
    {
        $aData['create_date'] = date("Y-m-d H:i:s");
        $aData['isactive'] = 1;
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
        //$this->tableGateway->delete(array('id' => $id));
        
        $dbAdapter = $this->tableGateway->getAdapter();
         
        $stmt = $dbAdapter->createStatement();
        $stmt->prepare('CALL comment_delete(?)');
        $stmt->getResource()->bindParam(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public function getListAdmin()
    {
        $select = new Select();
        $select->columns(array('comment_id', 'price', 'comment_content', 'comment_parent', 'create_date', 'account_id', 'fullname'));
        $select->from('comments');
        $select->order('create_date desc');
    
        // create a new pagination adapter object
        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter()
        );
    
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    public function getLst($iObjectId, $iObjectType)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(
            array(
                'object_id',
                'object_type',
                'comment_id',
                'comment_content',
                'comment_parent',
                'price',
                'create_date',
                'account_id',
                'fullname',
                'avatar',
                'number_like',
            )
        );
        
        $where = new Where();
        $where->equalTo('isactive', 1);
        $where->equalTo('object_id', $iObjectId);
        $where->equalTo('object_type', $iObjectType);
        $select->where($where);
       
        $select->order('create_date');
        
        //echo $select->getSqlString();
        //exit;
    
        $aResult = $this->tableGateway->selectWith($select);
        return $aResult;
    }
    
    public function getListParent($iObjectId, $iObjectType)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(
            array(
                'object_id',
                'object_type',
                'comment_id',
                'comment_content',
                'comment_parent',
                'price',
                'create_date',
                'account_id',
                'fullname',
                'avatar',
                'number_like',
                'number_comment',
            )
        );
        
        $where = new Where();
        $where->equalTo('isactive', 1);
        $where->equalTo('comment_parent', 0);
        $where->equalTo('object_id', $iObjectId);
        $where->equalTo('object_type', $iObjectType);
        $select->where($where);
         
        $select->order('create_date');
        
        $aResult = $this->tableGateway->selectWith($select);
        return $aResult;
    }
    
    public function getChildComment($id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(
            array(
                'object_id',
                'object_type',
                'comment_id',
                'comment_content',
                'comment_parent',
                'price',
                'create_date',
                'account_id',
                'fullname',
                'avatar',
                'number_like',
                'number_comment',
            )
        );
        
        $where = new Where();
        $where->equalTo('isactive', 1);
        $where->equalTo('comment_parent', $id);
        $select->where($where);
         
        $select->order('create_date');
        
        $aResult = $this->tableGateway->selectWith($select);
        return $aResult;
    }
    
    public function getMyComment($iAccountId)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(
            array(
                'object_id',
                'object_type',
                'comment_id',
                'comment_content',
                'comment_parent',
                'price',
                'create_date',
                'account_id',
                'fullname',
                'avatar',
                'number_like',
            )
        );
        
        $where = new Where();
        $where->equalTo('isactive', 1);
        $where->equalTo('account_id', $iAccountId);
        $select->where($where);
         
        $select->order('create_date');
        
        $aResult = $this->tableGateway->selectWith($select);
        return $aResult;
    }
}

?>