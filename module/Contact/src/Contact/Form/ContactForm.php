<?php
namespace Contact\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class ContactForm extends Form
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
            'required' => true,
        ));
        $this->add($fullname);
        
        $email = new Element\Email('email');
        $email->setAttributes(array(
            'class' => 'form-control',
            'required' => true,
        ));
        $this->add($email);
    
        $content = new Element\Textarea('content');
        $content->setAttributes(array(
            'class' => 'form-control',
        ));
        $this->add($content);
    }
    
    public function addValidate()
    {
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
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'content',
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
                            'isEmpty' => 'Vui lòng nhập nội dung cần liên hệ'
                        )
                    )
                ),
            ),
        ));
    
        $this->setInputFilter($inputFilter);
    }
}

?>