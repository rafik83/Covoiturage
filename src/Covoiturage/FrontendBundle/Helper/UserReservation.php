<?php
/**
 * 
 * User: wissem
 * Date: 06/12/2014
 * Time: 10:28
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Helper;

class UserReservation
{

    private $user;

    private  $listVoyages;

    private $em;

    public function __construct($user,$listVoyages,$em)
    {
        $this->user = $user;
        $this->listVoyages  = $listVoyages;
        $this->em = $em;

    }

    public function setUserReservations()
    {
        $userReservations = null;
        foreach($this->listVoyages as $voyage) {
            $userReservations[$voyage->getId()] = 0;
            if ($this->user){
                $userReservations[$voyage->getId()] = $this->em->getRepository('CovoiturageFrontendBundle:Reservation')
                    ->getUserReservations($voyage->getId(), $this->user->getId());

            }
        }


        return $userReservations;
    }

} 