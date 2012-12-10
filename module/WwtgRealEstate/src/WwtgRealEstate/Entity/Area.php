<?php
namespace WwtgRealEstate\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use wtgRealEstate\Entity\Address;
use Zend\Form\Annotation;

/**
* Area
*
* @ORM\Entity(repositoryClass="WwtgRealEstate\Repositories\AreaRepository")
* @ORM\Table(name="area")
*/
class Area
{


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Required(false)
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;


    /**
     * @ORM\Column(type="string")
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Options({"label":"Area:"})
     */
    protected $area_name;


    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="area", cascade={"ALL"}) @var $addressArea[]
     * @Annotation\Exclude()
     */
    protected $addressArea = null;


    public function __construct() {
        $this->areaAddress = new ArrayCollection();
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
        $this->area_id   = $data['area_id'];
        $this->area_name = $data['area_name'];
    }



}