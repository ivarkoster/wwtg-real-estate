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
use WwtgRealEstate\Form\BrokerForm;
use WwtgRealEstate\Form\CountryForm;
use Doctrine\ORM\EntityManager;
use WwtgRealEstate\Entity\Broker;
use WwtgRealEstate\Entity\Country;

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

        //haal de Broker Web Form op en verander de submit label
        $brokerForm = new BrokerForm();
        $brokerForm->get('submit')->setAttribute('label', 'Add');

        $addressForm = new AddressForm();

        //haal de Country Web Form op en vul de landen select box met aanwezige landen
        $addressForm = new AddressForm();
        //set countryname select options
        $countryOptions = $this->getEntityManager()
            ->getRepository('WwtgRealEstate\Entity\Country')
            ->selectOptionsArray();
        $addressForm->get('countryName')->setValueOptions($countryOptions);

        //set LocationName select options
        $locationOptions = $this->getEntityManager()
            ->getRepository('WwtgRealEstate\Entity\Location')
            ->selectOptionsArray();
        $addressForm->get('locationName')->setValueOptions($locationOptions);

        //set AreaName select options
        $areaOptions = $this->getEntityManager()
            ->getRepository('WwtgRealEstate\Entity\Area')
            ->selectOptionsArray();
        $addressForm->get('locationName')->setValueOptions($areaOptions);


        $request = $this->getRequest();
        if ($request->isPost()) {


            $broker = new Broker();
            $brokerForm->setInputFilter($broker->getInputFilter());
            $brokerForm->setData($request->getPost());

            $address = new Address();
            $addressForm->setInputFilter($address->getInputFilter());
            $addressForm->setData($request->getPost());

            if ($brokerForm->isValid() && $countryForm->isValid()) {

                $broker->populate($brokerForm->getData());


                $this->getEntityManager()->persist($broker);
                $this->getEntityManager()->flush();

                //redirect to list of albums
                return $this->redirect()->toRoute('real-estate');
            }
        }

        return array(
            'brokerForm' => $brokerForm,
            'addressForm' => $addressForm,
        );
    }
}
