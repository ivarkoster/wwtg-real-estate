<?php
namespace WwtgRealEstate\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use wtgRealEstate\Entity\Broker;

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
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="countryAddress")
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
     * @ORM\Column(type="string", length=45)
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
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Options({"label":"Streetname:"})
     * @Annotation\ErrorMessage("E-mail address did not validate")
     */
    protected $street;

    /**
     * @ORM\Column(type="integer")
     * @Annotation\Filter({"name":"Int"})
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
     * @Annotation\ErrorMessage("Could not validate E-mail address")
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
     * @ORM\OneToMany(targetEntity="Broker", mappedBy="address") @var addressBroker[]
     * @Annotation\Exclude()
     */
    protected $addressBroker = null;

    /**
     * constructor
     */
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

}