<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/WwtgRealEstate for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace WwtgRealEstate\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Doctrine\ORM\EntityManager;
use WwtgRealEstate\Entity\Broker;
use WwtgRealEstate\Entity\Country;
use WwtgRealEstate\Entity\Address;
use Zend\Form\Element;
use Zend\Form\Form;

class BrokerController extends AbstractActionController
{

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Setter voor $em property
     *
     * @param EntitiyManager $em
     * @return void
     */
    public function setEntityManager(EntitiyManager $em)
    {
        $this->em = $em;
    }

    /**
     * Retourneerd de Doctrine Entitymanager
     *
     * @param EntitiyManager $em
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager') ;
        }
        return $this->em;
    }

    public function indexAction()
    {
        return array();
    }

    public function addAction()
    {
        $address     = new Address();
        $broker      = new Broker();
        $builder     = new AnnotationBuilder();
        $csrf        = new Element\Csrf('csrf');

        $brokerForm  = $builder->createForm(new Broker());
        $addressForm = $builder->createForm(new Address());
        $addressForm->add($csrf);

        $request = $this->getRequest();
        if ($request->isPost()) {

            $brokerForm->bind($broker);
            $addressForm->bind($address);

            $brokerForm->setData($request->getPost());
            $addressForm->setData($request->getPost());

            $addresFormValid = $addressForm->isValid();
            $brokerFormValid = $brokerForm->isValid();

            if ( $addresFormValid &&  $brokerFormValid ) {


                $this->getEntityManager()->persist($address);
                $this->getEntityManager()->flush();

                $broker->setAddress($address);
                $this->getEntityManager()->persist($broker);

                $this->getEntityManager()->flush();



                //redirect to list of albums
                //return $this->redirect()->toRoute('broker');
            }
        }

        return array(
            'addressForm' => $addressForm,
            'brokerForm' => $brokerForm,
        );
    }


}
