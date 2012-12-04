<?php
namespace WwtgRealEstate\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use WwtgRealEstate\Entity\Broker;
use WwtgRealEstate\Entity\Area;

/**
* A photo album.
*
* @ORM\Entity
* @ORM\Table(name="address")
* @Annotation\name("Address")
* @Annotation\Hydrator("Zend\stdlib\Hydrator\ObjectProperty")
* @
*/
class Address
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Exclude()
     */
    protected $address_id;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="countryAddress", cascade={"persist"})
     * @Annotation\Exclude()
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="areaAddress")
     * @Annotation\Exclude()
     */
    protected $area;

    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="locationAddress")
     * @Annotation\Exclude()
     */
    protected $location;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Longitude:"})
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string", length=45)
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Latitude:"})
     */
    protected $latitude;

    /**
     * @ORM\Column(type="string", length=45)
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Options({"label":"Streetname:"})
     */
    protected $street;

    /**
     * @ORM\Column(type="integer")
     * @Annotation\Filter({"name":"Int"})
     * @Annotation\Validator({"name":"Int"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"House number:"})
     */
    protected $housenr;

    /**
     * @ORM\Column(type="string", length=5)
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":5}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Extension:"})
     */
    protected $housenr_ext;

    /**
     * @ORM\Column(type="string", length=15)
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":15}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Postalcode:"})
     */
    protected $postalcode;

    /**
     * @ORM\Column(type="string", length=45)
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"City:"})
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=45)
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Required(false)
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"State:"})
     */
    protected $state;

    /**
     * @ORM\OneToMany(targetEntity="Broker", mappedBy="address_id") @var brokerAddress[]
     * @Annotation\Exclude()
     */
    protected $brokerAddress = null;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->brokerAddress = new ArrayCollection();
    }


    public function addBrokerAddress(Broker $broker)
    {
        $this->brokerAddress[] = $broker;
    }


    public function getId()
    {
        return $this->address_id;
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
        $this->address_id = isset($data['realestate_broker_id']) ? $data['realestate_broker_id'] : null;
        $this->is_application_owner = isset($data['is_application_owner']) ? $data['is_application_owner'] : null;
        $this->name                 = isset($data['name']) ? $data['name'] : null;
        $this->email                = isset($data['email']) ? $data['email'] : null;
        $this->phone                = isset($data['phone']) ? $data['phone'] : null;
        $this->mobile               = isset($data['mobile']) ? $data['mobile'] : null;
        $this->fax                  = isset($data['fax']) ? $data['fax'] : null;
    }
}