<?php
namespace WwtgRealEstate\Repositories;

use Doctrine\ORM\EntityRepository;


class AreaRepository extends EntityRepository
{

    public function selectOptionsArray()
    {
        $dql = "SELECT a.id, a.area_name FROM WwtgRealEstate\Entity\Area a";
        $query = $this->getEntityManager()->createQuery($dql);
        $areas = $query->getResult();

        foreach ($areas as $area) {
            $retval[$area['id']] = $area['area_name'];
        }

        return is_array($retval) ? $retval : array();
    }



}