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

        $brokerForm = new BrokerForm();
        $brokerForm->get('submit')->setAttribute('label', 'Add');


        $countryForm = new CountryForm();
        $countryOptions = $this->getEntityManager()
            ->getRepository('WwtgRealEstate\Entity\Country')
            ->selectOptionsArray();
        $countryForm->get('name')->setValueOptions($countryOptions);

        //$locationForm = new CountryForm();
        //$areaForm = new CountryForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $broker = new Broker();
            $brokerForm->setInputFilter($album->getInputFilter());
            $brokerForm->setData($request->getPost());

            if ($brokerForm->isValid()) {
                $broker->populate($form->getData());
                $this->getEntityManager()->persist($broker);
                $this->getEntityManager()->flush();

                //redirect to list of albums
                return $this->redirect()->toRoute('real-estate');
            }
        }

        return array(
            'brokerForm' => $brokerForm,
            'countryForm' => $countryForm,
        );
    }
}
