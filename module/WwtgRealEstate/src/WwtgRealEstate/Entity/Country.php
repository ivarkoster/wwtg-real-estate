<?php
namespace WwtgRealEstate\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use WwtgRealEstate\Entity\Broker;
use WwtgRealEstate\Entity\Area;
/**
* Country
*
* @ORM\Entity(repositoryClass="WwtgRealEstate\Repositories\CountryRepository")
* @ORM\Table(name="country")

*/
class Country
{


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Required(false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Annotation\
     */
    protected $country_name;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="country") @var $addressCountry[]
     */
    protected $addressCountry = null;

    /**
     * @ORM\OneToMany(targetEntity="Area", mappedBy="country") @var $areaCountry[]
     */
    protected $areaCountry = null;


    public function __construct()
    {
        $addressCountry = new ArrayCollection();
        $areaCountry    = new ArrayCollection();
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
        $this->id           = $data['id'];
        $this->country_name = $data['country_name'];
    }



}