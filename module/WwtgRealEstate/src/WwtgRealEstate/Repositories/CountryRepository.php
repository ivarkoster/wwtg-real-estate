<?php
namespace WwtgRealEstate\Repositories;

use Doctrine\ORM\EntityRepository;


class CountryRepository extends EntityRepository
{

    public function selectOptionsArray()
    {
        $dql = "SELECT c.id, c.country_name FROM WwtgRealEstate\Entity\Country c";
        $query = $this->getEntityManager()->createQuery($dql);
        $countries = $query->getResult();

        foreach ($countries as $country) {
            $retval[$country['id']] = $country['country_name'];
        }


        return is_array($retval) ? $retval : array();
    }



}