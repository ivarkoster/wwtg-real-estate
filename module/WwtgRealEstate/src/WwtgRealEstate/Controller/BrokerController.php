<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/WwtgRealEstate for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace WwtgRealEstate\Controller;

use Doctrine\ORM\EntityManager;
use WwtgRealEstate\Entity\Address;
use WwtgRealEstate\Entity\Area;
use WwtgRealEstate\Entity\Broker;
use WwtgRealEstate\Entity\Country;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;

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
        //roep de Enteties aan
        $address     = new Address();
        $broker      = new Broker();
        $area        = new Area();
        $builder     = new AnnotationBuilder();

        //maak een Cros site request forgery beveiliging aan
        $csrf        = new Element\Csrf('csrf');

        //maak aan de hand van de annotaties de form
        $brokerForm  = $builder->createForm(new Broker());
        $addressForm = $builder->createForm(new Address());
        $areaForm    = $builder->createForm(new Area());
        //voog CSRF beveiliging toe aan form
        $addressForm->add($csrf);
        //haal Areas op uit Area repository
        $areas = $this->getEntityManager()->getRepository('WwtgRealEstate\Entity\Area')->selectOptionsArray();
        //print_r($areas);
        //set de option values voor de area select element
        $areaForm->get('area_name')->setOptions(array('options' => $areas));

        //Bind de de Forms aan de Entities
        $brokerForm->bind($broker);
        $addressForm->bind($address);
        $areaForm->bind($area);

        $request = $this->getRequest();
        if ($request->isPost()) {


            //set post data
            $brokerForm->setData($request->getPost());
            $addressForm->setData($request->getPost());
            $areaForm->setData($request->getPost());
            //valideer post data
            $addresFormValid = $addressForm->isValid(); //bind form
            $brokerFormValid = $brokerForm->isValid();  //bind form
            $areaFormValid   = $areaForm->isValid();     //bind form

            if ( $addresFormValid  && $brokerFormValid && $areaFormValid) {

                print_r($broker);
                //map address entity aan broker entity
                $broker->setAddress($address);
                //persist en flush
                $this->getEntityManager()->persist($broker);
                $this->getEntityManager()->flush();
                //redirect to list of albums
                //return $this->redirect()->toRoute('broker');
            } else {

                foreach ($brokerForm->getMessages() as $messageId => $message) {
                    echo "Broker validation failure '$messageId': $message<br />\n";
                }

                foreach ($addressForm->getMessages() as $messageId => $message) {
                    echo "Address validation failure '$messageId': $message<br />\n";
                }

                foreach ($areaForm->getMessages() as $messageId => $message) {
                    echo "Area validation failure '$messageId': $message<br />\n";
                }
            }

        }
        //geef data door aan view
        return array(
            'addressForm' => $addressForm,
            'brokerForm' => $brokerForm,
            'areaForm' => $areaForm,
        );
    }


}
