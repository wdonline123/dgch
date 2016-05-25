<?php
namespace Apartment\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class ApartmentForm extends Form
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
        $name = new Element\Text('name');
        $name->setAttributes(array(
            'class' => 'col-xs-10 col-sm-5',
        ));
        $this->add($name);
        
        $position = new Element\Text('position');
        $position->setAttributes(array(
            'class' => 'col-xs-10 col-sm-5',
        ));
        $this->add($position);
        
        $picture = new Element\Hidden('picture');
        $picture->setAttributes(array(
            'id' => 'poster-article',
        ));
        $this->add($picture);
        
        $city = new Element\Select('city');
        $city->setValueOptions($this->aOption['city']);
        $this->add($city);
        
        $district = new Element\Select('district');
        //$district->setEmptyOption("-- District --");
        $district->setValueOptions($this->aOption['district']);
        $this->add($district);
        
        $introduction = new Element\Textarea('introduction');
        $introduction->setAttributes(array(
            'id' => 'introduction',
        ));
        $this->add($introduction);
        
        $utility = new Element\Textarea('utility');
        $utility->setAttributes(array(
            'id' => 'utility',
        ));
        $this->add($utility);
        
        $minPrice = new Element\Text('min_price');
        $minPrice->setAttributes(array(
            'placeholder' => 'Min',
        ));
        $this->add($minPrice);
        
        $maxPrice = new Element\Text('max_price');
        $maxPrice->setAttributes(array(
            'placeholder' => 'Max',
        ));
        $this->add($maxPrice);
        
        $type = new Element\Select('type');
        $type->setEmptyOption("-- Chọn --");
        $type->setValueOptions(
            array(
                1 => 'Căn hộ cao cấp',
                2 => 'Căn hộ trung cấp'
            )
        );
        $this->add($type);
    }
    
    public function addValidate()
    {
        $inputFilter = new InputFilter();
    
        $inputFilter->add(array(
            'name' => 'name',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
    
        $this->setInputFilter($inputFilter);
    }
    
    public function editValidate()
    {
        $inputFilter = new InputFilter();
    
        $inputFilter->add(array(
            'name' => 'name',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
    
        $this->setInputFilter($inputFilter);
    }
}

?>