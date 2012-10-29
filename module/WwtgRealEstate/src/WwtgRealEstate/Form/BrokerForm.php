<?php
namespace WwtgRealEstate\Form;

use Zend\Form\Form;

class BrokerForm extends Form {

    public function __construct($name = null){

        //we want to ignore the name passed
        parent::__construct('album');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'RealEstateBrokerId',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'isApplicationOwner',
            'attributes' => array(
                'type' => 'radio',
            ),
            'options' => array(
                'label' => 'Yes',
                'Value' => '1'
            ),
        ));
        $this->add(array(
            'name' => 'isApplicationOwner',
            'attributes' => array(
                'type' => 'radio',
            ),
            'options' => array(
                'label' => 'No',
                'Value' => '0'
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Name Broker',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Phone',
            ),
        ));
        $this->add(array(
            'name' => 'mobile',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'mobile',
            ),
        ));
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'fax',
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