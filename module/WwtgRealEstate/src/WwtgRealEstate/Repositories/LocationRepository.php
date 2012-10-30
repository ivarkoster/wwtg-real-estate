<?php
namespace WwtgRealEstate\Repositories;

use Doctrine\ORM\EntityRepository;


class LocationRepository extends EntityRepository
{

    public function selectOptionsArray()
    {
        $dql = "SELECT l.LocationId as id, l.name FROM WwtgRealEstate\Entity\Location l";
        $query = $this->getEntityManager()->createQuery($dql);
        $location = $query->getResult();

        foreach ($locations as $location) {
            $retval[$location['id']] = $location['name'];
        }

        return is_array($retval) ? $retval : array();
    }



}