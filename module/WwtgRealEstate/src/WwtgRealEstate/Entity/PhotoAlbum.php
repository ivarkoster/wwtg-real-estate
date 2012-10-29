<?php
namespace WwtgPhotoAlbum\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* A photo album.
*
* @ORM\Entity(repositoryClass="PhotoAlbum\Repositories\PhotoAlbumRepository")
* @ORM\Table(name="photoalbum")
* @property int $id
* @property int $parent
* @property string $title
* @property boolean $active
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
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="PhotoAlbum", inversedBy="albumChilds")
     */
    protected $parent;

    /**
     * @ORM\Column(length=45)
     */
    protected $title;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @OneToMany(targetEntity="Photo", mappedBy="photo") @var Bug[]
     */
    protected $albumPhotos = null;

    /**
     * @ORM\OneToMany(tagetEntity="PhotoAlbum", mappedBy="parent") @var PhotoAlbum[]
     */
    protected $albumChilds = null;




    public function __construct()
    {
        $this->albumPhotos = new ArrayCollection();
        $this->albumChilds = new ArrayCollection();
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
     * @param PhotoAlbum\Entity\PhotoAlbum $albumChild
     * @return void
     */
    public function addAlbumChild($albumChild)
    {
        $albumChilds[] = $albumChild;
    }

    public function setParent($photoAlbum)
    {
        $photoAlbum->addAlbumChild($this);
        $this->parent = $photoAlbum;
    }

    /**
     * @param PhotoAlbum\Entity\PhotoAlbum $photo
     * @return void
     */
    public function addPhoto($photo)
    {
        $albumPhotos[] = $photo;
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
        $this->id     = $data['id'];
        $this->artist = $data['artist'];
        $this->title  = $data['title'];
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
                'name'     => 'parent',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
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
                'name'     => 'active',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Bool'),
                )
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}