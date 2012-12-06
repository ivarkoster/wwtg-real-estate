<?php
namespace WwtgRealEstate\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use WwtgRealEstate\Entity\Address;

/**
* Real Estate Broker
*
* @ORM\Entity(repositoryClass="WwtgRealEstate\Repositories\BrokerRepository")
* @ORM\Table(name="realestate_broker")
*/
class Broker
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Address", inversedBy="brokerAddress", cascade={"persist"})
     * @Annotation\Exclude()
     */
    protected $address = null;

    /**
     * @ORM\Column(type="boolean")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Options({"label":"Is Application Owner:"})
     */
    protected $is_application_owner;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Broker Name:"})
     */
    protected $broker_name;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Options({"label":"Email:"})
     * @Annotation\ErrorMessage("E-mail address did not validate")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Phone number:"})
     */
    protected $phone;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Mobile phone:"})
     */
    protected $mobile;

    /**
     * @ORM\Column(type="string")
     * @Annotation\Filter({"name":"StringTrim", "name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Fax:"})
     */
    protected $fax;


    public function __construct()
    {
        $this->address = new ArrayCollection();
    }


    public function setAddress(Address $address)
    {

        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
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
        $this->id                   = isset($data['id']) ? $data['id'] : null;
        $this->is_application_owner = isset($data['is_application_owner']) ? $data['is_application_owner'] : null;
        $this->broker_name          = isset($data['broker_name']) ? $data['broker_name'] : null;
        $this->email                = isset($data['email']) ? $data['email'] : null;
        $this->phone                = isset($data['phone']) ? $data['phone'] : null;
        $this->mobile               = isset($data['mobile']) ? $data['mobile'] : null;
        $this->fax                  = isset($data['fax']) ? $data['fax'] : null;
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


}