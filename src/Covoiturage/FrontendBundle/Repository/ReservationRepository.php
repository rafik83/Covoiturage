<?php
/**
 * 
 * User: wissem
 * Date: 22/11/2014
 * Time: 22:01
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Repository;

use Covoiturage\FrontendBundle\Entity\Reservation;
use Doctrine\ORM\EntityRepository;
use \Doctrine\ORM\Tools\Pagination\Paginator;


class ReservationRepository extends EntityRepository
{

    /**
     * Get the number of Reservations
     *
     * @param int $voyage
     * @param int $status
     * @return int
     */
    public function getNbReservations($voyage, $status = Reservation::CONFIRMED )
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(reservation.id)')
            ->from('CovoiturageFrontendBundle:Reservation','reservation')
            ->where('reservation.status = :status')
            ->andWhere('reservation.voyage = :voyage')

        ;
        $params = array();
        $params['status'] = $status;
        $params['voyage'] = $voyage;
        $qb->setParameters($params);


        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

    public function getUserReservations($voyage, $user )
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(reservation.id)')
            ->from('CovoiturageFrontendBundle:Reservation','reservation')
            ->where('reservation.voyage = :voyage')
            ->andWhere('reservation.utilisateur = :utilisateur')
        ;

        $params = array();
        $params['voyage'] = $voyage;
        $params['utilisateur'] = $user;
        $qb->setParameters($params);

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

} 