<?php
namespace WwtgRealEstate\Repositories;

use Doctrine\ORM\EntityRepository;


class AreaRepository extends EntityRepository
{

    public function selectOptionsArray(array $country = null)
    {
        if (isset($country)){
            $where = 'WHERE a.country IN (:cids)';
        }

        $dql = "SELECT a.id, a.area_name FROM WwtgRealEstate\Entity\Area a $where";
        $query = $this->getEntityManager()->createQuery($dql);
        if (isset($country)) {
            $query->setParameter(':cids', $country);
        }
        $areas = $query->getResult();

        foreach ($areas as $area) {
            $retval[$area['id']] = $area['area_name'];
        }

        return is_array($retval) ? $retval : array();
    }



}