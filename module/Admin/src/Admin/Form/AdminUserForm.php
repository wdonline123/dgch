<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class AdminUserForm extends Form
{
    protected $aOption;
    protected $inputFilter;
    
    public function __construct($sName, $aOption)
    {
        parent::__construct($sName, $aOption);
        $this->aOption = $aOption;
        $this->addElement();
    }
    
    public function addElement()
    {
        $fullname = new Element\Text('fullname');
        $fullname->setAttributes(array(
            'class' => 'col-xs-10 col-sm-5',
        ));
        $this->add($fullname);
    
        $username = new Element\Text('username');
        $username->setAttributes(array(
            'class' => 'col-xs-10 col-sm-5',
        ));
        $this->add($username);
    
        $password = new Element\Password('password');
        $password->setAttributes(array(
            'class' => 'col-xs-10 col-sm-5',
        ));
        $this->add($password);
        
        
        $retypePassword = new Element\Password('retype-password');
        $retypePassword->setAttributes(array(
            'class' => 'col-xs-10 col-sm-5',
        ));
        $this->add($retypePassword);
        
        $email = new Element\Text('email');
        $email->setAttributes(array(
            'class' => 'col-xs-10 col-sm-5',
        ));
        $this->add($email);
    
        $group_id = new Element\Select('group_id');
        $group_id->setEmptyOption("-- Select --");
        $group_id->setValueOptions($this->aOption['group']);
        $this->add($group_id);
    }
    
    public function addValidate()
    {
        $dbAdapter = GlobalAdapterFeature::getStaticAdapter();
        $inputFilter = new InputFilter();
    
        $inputFilter->add(array(
            'name' => 'fullname',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'admin_user',
                        'field' => 'username',
                        'adapter' => $dbAdapter,
                        'messages' => array(
                            'recordFound' => 'Username already exists, please input another username',
                        )
                    ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'retype-password',            
            'validators' => array(
                array(
                    'name'    => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'admin_user',
                        'field' => 'email',
                        'adapter' => $dbAdapter,
                        'messages' => array(
                            'recordFound' => 'Email already exists, please input another email',
                        )
                    ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'group_id',
            'required' => true,
        ));
    
        $this->setInputFilter($inputFilter);
    }
    
    public function editValidate($id)
    {
        $dbAdapter = GlobalAdapterFeature::getStaticAdapter();
        $sClause    = 'id != ' . $id;
        $inputFilter = new InputFilter();
    
        $inputFilter->add(array(
            'name' => 'fullname',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'admin_user',
                        'field' => 'username',
                        'adapter' => $dbAdapter,
                        'exclude' => $sClause,
                        'messages' => array(
                            'recordFound' => 'Username already exists, please input another username',
                        )
                    ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'admin_user',
                        'field' => 'email',
                        'adapter' => $dbAdapter,
                        'exclude' => $sClause,
                        'messages' => array(
                            'recordFound' => 'Email already exists, please input another email',
                        )
                    ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'group_id',
            'required' => true,
        ));
    
        $this->setInputFilter($inputFilter);
    }
}

?>