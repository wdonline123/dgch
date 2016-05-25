<?php
namespace Like\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class LikeTable
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
        $this->tableGateway->update($aData, array('like_id' => $id));
    }
    
    public function getData($id)
    {
        $rowset = $this->tableGateway->select(array('like_id' => $id));
        $row = $rowset->current();
        return $row;
    }
    
    public function delete($id)
    {
        $this->tableGateway->delete(array('like_id' => $id));
    }
    
    public function getListMember($iObjectId, $iObjectType)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array('like_id', 'account_id', 'fullname', 'avatar'));
        $select->where(array(
            'object_id' => $iObjectId,
            'object_type' => $iObjectType,
        ));
        $select->order('create_date desc');
        $select->limit(50);
         
        $arrResult = $this->tableGateway->selectWith($select);
        return $arrResult;
    }
    
    public function checkMemberLikeObject($iAccountId, $iObjectId, $iObjectType)
    {
        $arrResult = array();
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array('like_id', 'object_id', 'comment_id'));
        $select->where(array(
            'account_id' => $iAccountId,
            'object_id' => $iObjectId,
            'object_type' => $iObjectType,
        ));
         
        return $this->tableGateway->selectWith($select);
    }
    
    public function getDataByObject($aData)
    {
        $rowset = $this->tableGateway->select(
            array(
                'account_id'    => $aData['account_id'],
                'object_id'     => $aData['object_id'],
                'object_type'   => $aData['object_type'],
            )
        );
        $row = $rowset->current();
        return $row;
    }
    
}

?>