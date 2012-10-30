<?php
namespace WwtgRealEstate\Repositories;

use Doctrine\ORM\EntityRepository;


class AreaRepository extends EntityRepository
{

    public function selectOptionsArray()
    {
        $dql = "SELECT a.AreaId as id, a.name FROM WwtgRealEstate\Entity\Area a";
        $query = $this->getEntityManager()->createQuery($dql);
        $areas = $query->getResult();

        foreach ($areas as $area) {
            $retval[$area['id']] = $area['name'];
        }

        return is_array($retval) ? $retval : array();
    }



}