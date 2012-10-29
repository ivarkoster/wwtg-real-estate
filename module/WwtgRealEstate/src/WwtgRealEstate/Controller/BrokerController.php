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
use WwtgRealEstate\Entity\Broker;

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
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }


    public function indexAction()
    {
        return array();
    }

    public function addAction()
    {

        $brokerFoorm = new BrokerForm();
        $brokerFoorm->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $broker = new Broker();
            $brokerFoorm->setInputFilter($album->getInputFilter());
            $brokerFoorm->setData($request->getPost());

            if ($brokerFoorm->isValid()) {
                $broker->populate($form->getData());
                $this->getEntityManager()->persist($broker);
                $this->getEntityManager()->flush();

                //redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array('form' => $form);
    }
}
