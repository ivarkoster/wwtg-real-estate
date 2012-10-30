<?php
namespace WwtgRealEstate\Repositories;

use Doctrine\ORM\EntityRepository;


class CountryRepository extends EntityRepository
{

    public function selectOptionsArray()
    {
        $dql = "SELECT c.CountryId as id, c.name FROM WwtgRealEstate\Entity\Country c";
        $query = $this->getEntityManager()->createQuery($dql);
        $countries = $query->getResult();

        foreach ($countries as $country) {
            $retval[$country['id']] = $country['name'];
        }


        return is_array($retval) ? $retval : array();
    }



}