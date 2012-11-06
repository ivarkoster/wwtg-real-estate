<?php
namespace WwtgRealEstate\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Location
*
* @ORM\Entity(repositoryClass="WwtgRealEstate\Repositories\LocationRepository")
* @ORM\Table(name="location")
* @property int $location_id
* @property string $location_name
*/
class Location implements InputFilterAwareInterface
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
    protected $location_id;


    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $location_name;


    /**
     * @OneToMany(targetEntity="Address", mappedBy="location") @var $locationAddress[]
     */
    protected $locationAddress = null;



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
        $this->location_id   = $data['location_id'];
        $this->location_name = $data['location_name'];
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
                'name'     => 'location_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                )
            )));

            //input filter for name of broker
            $inputFilter->add($factory->createInput(array(
                'name'     => 'location_name',
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

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}