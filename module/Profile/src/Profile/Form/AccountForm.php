<?php
namespace Profile\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class AccountForm extends Form
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
            'class' => 'form-control',
            'required' => true
        ));
        $this->add($fullname);
        
        $email = new Element\Email('email');
        $email->setAttributes(array(
            'class' => 'form-control',
            'required' => true
        ));
        $this->add($email);
    
        $password = new Element\Password('password');
        $password->setAttributes(array(
            'class' => 'form-control',
            'required' => true
        ));
        $this->add($password);
    }
    
    public function addValidate()
    {
        $dbAdapter      = GlobalAdapterFeature::getStaticAdapter();
        
        $inputFilter = new InputFilter();
    
        $inputFilter->add(array(
            'name' => 'fullname',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Vui lòng nhập họ tên'
                        )
                    )
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Vui lòng nhập email'
                        )
                    )
                ),
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'accounts',
                        'field' => 'email',
                        'adapter' => $dbAdapter,
                        'messages' => array(
                            'recordFound' => 'Email này đã tồn tại'
                        )
                    ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Vui lòng nhập mật khẩu'
                        )
                    )
                ),
            ),
        ));
        
        $this->setInputFilter($inputFilter);
    }
}

?>