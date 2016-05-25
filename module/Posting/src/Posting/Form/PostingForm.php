<?php
namespace Posting\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class PostingForm extends Form
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
        $type = new Element\Select('type');
        $type->setAttributes(array(
            'class' => 'form-control',
        ));
        $type->setValueOptions($this->aOption['type']);
        $this->add($type);
        
        $title = new Element\Text('title');
        $title->setAttributes(array(
            'class' => 'form-control',
            'required' => true
        ));
        $this->add($title);
    
        $city_id = new Element\Select('city_id');
        $city_id->setAttributes(array(
            'id' => 'city_id',
            'class' => 'form-control',
        ));
        $city_id->setEmptyOption(" -- Thành phố -- ");
        $city_id->setValueOptions($this->aOption['city_id']);
        $this->add($city_id);
        
        /*
        $district_id = new Element\Select('district_id');
        $district_id->setAttributes(array(
            'id' => 'district_id',
            'class' => 'form-control',
        ));
        $district_id->setEmptyOption(" -- Quận -- ");
        $district_id->setValueOptions($this->aOption['district_id']);
        $district_id->setDisableInArrayValidator(true);
        $this->add($district_id);
        
        $apartment_id = new Element\Select('apartment_id');
        $apartment_id->setAttributes(array(
            'id' => 'apartment_id',
            'class' => 'form-control',
        ));
        $apartment_id->setEmptyOption(" -- Dự án -- ");
        $apartment_id->setValueOptions($this->aOption['apartment_id']);
        $apartment_id->setDisableInArrayValidator(true);
        $this->add($apartment_id);
        */
        
        $address = new Element\Text('address');
        $address->setAttributes(array(
            'class' => 'form-control',
        ));
        $this->add($address);
        
        $content = new Element\Textarea('content');
        $content->setAttributes(array(
            'class' => 'form-control',
            'style' => 'height: 250px',
        ));
        $this->add($content);
        
        $contact_fullname = new Element\Text('contact_fullname');
        $contact_fullname->setAttributes(array(
            'class' => 'form-control',
        ));
        $this->add($contact_fullname);
        
        $contact_phone = new Element\Text('contact_phone');
        $contact_phone->setAttributes(array(
            'class' => 'form-control',
        ));
        $this->add($contact_phone);
        
        $contact_email = new Element\Text('contact_email');
        $contact_email->setAttributes(array(
            'class' => 'form-control',
        ));
        $this->add($contact_email);
    }
    
    public function addValidate()
    {
        $inputFilter = new InputFilter();
        
        $inputFilter->add(array(
            'name' => 'title',
            'required' => true,
        ));
        
        $inputFilter->add(array(
            'name' => 'city_id',
            'required' => true,
        ));
        
        $inputFilter->add(array(
            'name' => 'address',
            'required' => false,
        ));
        
        $inputFilter->add(array(
            'name' => 'content',
            'required' => true,
        ));
        
        $inputFilter->add(array(
            'name' => 'contact_fullname',
            'required' => true,
        ));
        
        $inputFilter->add(array(
            'name' => 'contact_phone',
            'required' => true,
        ));
        
        $inputFilter->add(array(
            'name' => 'contact_email',
            'required' => true,
        ));
        
        $this->setInputFilter($inputFilter);
    }
}

?>