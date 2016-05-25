<?php
namespace Comment\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class CommentForm extends Form
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
        $price = new Element\Text('price');
        $this->add($price);
        
        $content = new Element\Textarea('comment_content');
        $content->setAttributes(array(
            'id' => 'comment_content',
        ));
        $this->add($content);
        
        $object_id = new Element\Hidden('object_id');
        $this->add($object_id);
        
        $object_type = new Element\Hidden('object_type');
        $this->add($object_type);
    }
    
    public function addValidate($min, $max)
    {
        $inputFilter = new InputFilter();
    
        $inputFilter->add(array(
            'name' => 'price',
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
                            'isEmpty' => 'Vui lòng nhập giá cho căn hộ'
                        )
                    )
                ),
                array(
                    'name' => 'Between',
                    'options' => array(
                        'min' => $min,
                        'max' => $max,
                        'inclusive' => true,
                        'messages' => array('notBetween' => 'Giá phải từ %min% đến %max%')
                    ),
                ),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'comment_content',
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
                            'isEmpty' => 'Vui lòng nhập ý kiến của bạn'
                        )
                    )
                ),
            ),
        ));
    
        $this->setInputFilter($inputFilter);
    }
}

?>