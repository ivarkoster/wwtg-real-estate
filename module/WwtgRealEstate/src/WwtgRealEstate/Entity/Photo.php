<?php
namespace WwtgPhotoAlbum\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* Photos
*
* @ORM\Entity(repositoryClass="PhotoAlbum\Repositories\PhotoAAlbumRepository")
* @ORM\Table(name="photoalbum")
* @property int $photo_id
* @property int $filename
* @property string $title
* @property datetime $upload_date
* @property string $upload_ip
* @property int $volgorde
* @property int $is360
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
    protected $photo_id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $filename;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $upload_date;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $upload_ip;

    /**
     * @ORM\Column(type="integer")
     */
    protected $order;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is360;

    /**
     * @ORM\ManyToOne(targetEntity="PhotoAlbum", inversedBy="albumPhotos")
     */
    protected $photoAlbum;


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


    public function setPhotoAlbum($photoAlbum)
    {
        $photoAlbum->addPhoto($this);
        $this->photoAlbum = $photoAlbum;
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
        $this->photo_id    = $data['photo_id'];
        $this->filename    = $data['filename'];
        $this->title       = $data['title'];
        $this->upload_date = $data['upload_date'];
        $this->upload_ip   = $data['upload_ip'];
        $this->volgorde    = $data['volgorde'];
        $this->is360       = $data['is360'];
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
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'filename',
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

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
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
                'name'     => 'upload_date',
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
                            'max'      => 21,
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'upload_ip',
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
            $inputFilter->add($factory->createInput(array(
                'name'     => 'volgorde',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
                'validators' => array(
                    array(
                        'name'    => "Between",
                        'options' => array(
                            'min'      => 0,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'is360',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
                'validators' => array(
                    array(
                        'name'    => "Between",
                        'options' => array(
                            'min'      => 0,
                            'max'      => 1,
                        ),
                    ),
                ),
            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}