<?php
namespace WwtgRealEstate\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* A photo album.
*
* @ORM\Entity(repositoryClass="WwtgRealEstate\Repositories\AddressRepository")
* @ORM\Table(name="address")
* @property int $address_id
* @property int $country_id
* @property int $area_id
* @property int $location_id
* @property string $longitude
* @property string $latitude
* @property string $street
* @property string $housenr
* @property string $housenr_ext
* @property string $postalcode
* @property string $city
* @property string $state
*/
class Album implements InputFilterAwareInterface
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
    protected $address_id;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="countryAddress")
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="areaAddress")
     */
    protected $area;

    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="locationAddress")
     */
    protected $location;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $street;

    /**
     * @ORM\Column(type="integer")
     */
    protected $housenr;

    /**
     * @ORM\Column(type="string", length=5)
     */
    protected $housenr_ext;

    /**
     * @ORM\Column(type="string", length=15)
     */
    protected $postalcode;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $state;

    /**
     * @OneToMany(targetEntity="Broker", mappedBy="address") @var addressBroker[]
     */
    protected $addressBroker = null;


    public function __construct()
    {
        $this->addressBroker = new ArrayCollection();
    }


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
        $this->address     = $data['address'];
        $this->country     = $data['country'];
        $this->area        = $data['area'];
        $this->location    = $data['area'];
        $this->longitude   = $data['longitude'];
        $this->latitude    = $data['latitude'];
        $this->street      = $data['street'];
        $this->housenr     = $data['housenr'];
        $this->housenr_ext = $data['housenr_ext'];
        $this->city        = $data['city'];
        $this->state       = $data['state'];
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

            $inputFilter->add($factory->createInput(array(
                'name'     => 'AddressId',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'longitude',
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
                            'max'      => 45,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'latitude',
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
                            'max'      => 45,
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'street',
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
                            'max'      => 45,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'housenr',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Between',
                        'options' => array(
                            'min' => 1,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'housenr_ext',
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
                            'max'      => 5,
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'postalcode',
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
                            'max'      => 15,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'city',
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
                            'max'      => 45,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'state',
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
                            'max'      => 45,
                        ),
                    ),
                ),
            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}