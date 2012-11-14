<?php
namespace WwtgRealEstate\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use wtgRealEstate\Entity\Address;
/**
* Photos
*
* @ORM\Entity(repositoryClass="WwtgRealEstate\Repositories\BrokerRepository")
* @ORM\Table(name="realestate_broker")
* @property int $realestate_broker_d
* @property int $address_id
* @property int $is_application_owner
* @property string $name
* @property string $email
* @property string $phone
* @property string $mobile
* @property string $fax
*/
class Broker implements InputFilterAwareInterface
{


    /**
     * @var Zend\InputFilter\InputFilter
     */
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $realestate_broker_id;

    /**
     * @ORM\ManyToOne(targetEntity="address", inversedBy="addressBroker")
     */
    protected $address;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_application_owner;

    /**
     * @ORM\Column(type="string")
     */
    protected $broker_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $phone;

    /**
     * @ORM\Column(type="string")
     */
    protected $mobile;

    /**
     * @ORM\Column(type="string")
     */
    protected $fax;



    /**
     * Magic getter to expose protected properties
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Magic setter to set the protected properties
     *
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }


    public function setAddress($address)
    {
        $address->assignedAddress($this);
        $this->address = $address;
    }

    /**
     * Conver the object to an array.
     *
     * @return array:
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


    /**
     * Populate $this from an array
     *
     * @param array $data
     * @return void
     */
    public function populate($data = array())
    {
        $this->realestate_broker_id = $data['realestate_broker_id'];
        $this->is_pplication_owner  = $data['is_application_owner'];
        $this->name                 = $data['name'];
        $this->email                = $data['email'];
        $this->phone                = $data['phone'];
        $this->mobile               = $data['mobile'];
        $this->fax                  = $data['fax'];
    }




    /* (non-PHPdoc)
     * @see Zend\InputFilter.InputFilterAwareInterface::setInputFilter()
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('Not used');
    }


    /* (non-PHPdoc)
     * @see Zend\InputFilter.InputFilterAwareInterface::getInputFilter()
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();


            //input filter for broker Id
            $inputFilter->add($factory->createInput(array(
                'name'     => 'RealEstateBrokerId',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                )
            )));

            //input filter for name of broker
            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => "StringLength",
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 45,
                        ),
                    ),
                ),
            )));

            //input filter for email address of broker
            $inputFilter->add($factory->createInput(array(
                'name'     => 'email',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => "StringLength",
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 85,
                        ),
                    ),
                    array(
                        'name'=> "EmailAddress",
                    ),
                ),
            )));

            //Create a array whit validator pareameters for phone/fax/mobile numbers
            $phoneFaxValidator =  array(
                'name'    => "StringLength",
                'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 3,
                    'max'      => 25,
                ),
            );

            //input filter for phone
            $inputFilter->add($factory->createInput(array(
                'name'     => 'phone',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array($phoneFaxValidator),
            )));

            //input filter for  mobile numbver
            $inputFilter->add($factory->createInput(array(
                'name'     => 'mobile',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array($phoneFaxValidator),
            )));

            //input filter for FAX
            $inputFilter->add($factory->createInput(array(
                'name'     => 'fax',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array($phoneFaxValidator),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}