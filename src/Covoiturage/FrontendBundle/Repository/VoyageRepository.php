<?php
/**
 * 
 * User: wissem
 * Date: 15/11/2014
 * Time: 19:31
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Repository;

use Doctrine\ORM\EntityRepository;
use \Doctrine\ORM\Tools\Pagination\Paginator;


class VoyageRepository extends EntityRepository
{
    /**
     * Get the list of voyages
     *
     * @param int $page
     * @param int $maxperpage
     * @return Paginator
     */
    public function getList($page=1, $maxperpage=10)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('voyage')
            ->from('CovoiturageFrontendBundle:Voyage','voyage')
            ->orderBy('voyage.id','DESC')
        ;

        $qb->setFirstResult(($page-1) * $maxperpage)
            ->setMaxResults($maxperpage);

        return new Paginator($qb);
    }

    /**
     * Get the number of Voyages
     *
     * @return int
     */
    public function countVoyages()
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(voyage.id)')
            ->from('CovoiturageFrontendBundle:Voyage','voyage')
        ;

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

    /**
     * Get the list of current user voyages
     *
     * @param int $user
     * @param int $page
     * @param int $maxperpage
     * @return Paginator
     */
    public function getUserList($user,$page=1, $maxperpage=10)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('voyage')
            ->from('CovoiturageFrontendBundle:Voyage','voyage')
            ->where('voyage.utilisateur = :user')
            ->orderBy('voyage.id','DESC')
            ->setParameter('user',$user)
        ;

        $qb->setFirstResult(($page-1) * $maxperpage)
            ->setMaxResults($maxperpage);

        return new Paginator($qb);
    }

    /**
     * Get the number of Voyages
     *
     * @param int $user
     * @return int
     */
    public function countUserVoyages($user)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(voyage.id)')
            ->from('CovoiturageFrontendBundle:Voyage','voyage')
            ->where('voyage.utilisateur=:user')
            ->setParameter('user',$user)
        ;

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

    /**
     * Get search voyages
     *
     * @param array $criteria (idDepart,idArrive,date)
     * @param int $page
     * @param int $maxperpage
     * @return Paginator
     */
    public function searchVoyages(array $criteria, $page=1, $maxperpage=10)
    {
        $params = array();
        $params['depart'] = $criteria['idDepart'];
        $params['arrive'] = $criteria['idArrive'];

        $qb = $this->_em->createQueryBuilder()
            ->select('voyage')
            ->from('CovoiturageFrontendBundle:Voyage','voyage')
            ->where('voyage.idDepart = :depart')
            ->andWhere('voyage.idArrive = :arrive')
        ;

        if (!empty($criteria['horaire'])) {
            $date = \DateTime::createFromFormat('j/m/Y H:i', $criteria['horaire']);
            if (is_object($date)) {
                $sDate = $date->format('Y-m-d H:i:s');
                $qb->andWhere('voyage.horaire = :horaire');
                $params['horaire'] = $sDate;
            }
        }
        $qb->setParameters($params);

        $qb->orderBy('voyage.id','DESC');


        $qb->setFirstResult(($page-1) * $maxperpage)
            ->setMaxResults($maxperpage);

        return new Paginator($qb);
    }

    /**
     * Get search count voyages
     *
     * @param array $criteria (idDepart,idArrive,date)
     * @return int
     */
    public function countVoyagesSearch(array $criteria)
    {
        $params = array();
        $params['depart'] = $criteria['idDepart'];
        $params['arrive'] = $criteria['idArrive'];

        $qb = $this->_em->createQueryBuilder()
            ->select('count(voyage.id)')
            ->from('CovoiturageFrontendBundle:Voyage','voyage')
            ->where('voyage.idDepart = :depart')
            ->andWhere('voyage.idArrive = :arrive')
        ;

        if (!empty($criteria['horaire'])) {
            $date = \DateTime::createFromFormat('j/m/Y H:i', $criteria['horaire']);
            if (is_object($date)) {
                $sDate = $date->format('Y-m-d H:i:s');
                $qb->andWhere('voyage.horaire = :horaire');
                $params['horaire'] = $sDate;
            }
        }
        $qb->setParameters($params);

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

} 