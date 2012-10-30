<?php
namespace WwtgRealEstate\Form;

use Zend\Form\Form;

class CountryForm extends Form {

    public function __construct($name = null){

        //we want to ignore the name passed
        parent::__construct('broker');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'CountryId',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Country',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));

    }

}