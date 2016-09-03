<?php
/**
 *
 * User: wissem
 * Date: 22/11/2014
 * Time: 22:08
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Controller;

use Covoiturage\FrontendBundle\Entity\Reservation;
use Covoiturage\FrontendBundle\Helper\MailingHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class ReservationController extends Controller
{

    //@Deprectad
    public function reservationAction($voyage)
    {
        $voyagesRservations = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Reservation')
            ->getNbReservations($voyage,Reservation::CONFIRMED);


        $userReservations = 0;
        $user = $this->getUser();
        if ($user){
            $userReservations = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Reservation')
                ->getUserReservations($voyage->getId(), $user->getId(), Reservation::CONFIRMED);

        }


        return $this->render('CovoiturageFrontendBundle:line:reservation.html.twig',                                       array( 'voyage_id'    => $voyage->getId(),
                                'nb_places'    => $voyage->getNbPlace(),
                                'voyage_reservations'    => $voyagesRservations,
                                'user_reservations'    => $userReservations,
                        )
                    );

    }

    public function reservationSubmitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $ret = array();

        $user = $this->getUser();
        if (!$user) {
            //@TODO:
            //handle save reservation with logged in user once it's done
            $ret['status'] = '302';
            $ret['url'] = $this->generateUrl('fos_user_security_login');
            return new JsonResponse($ret);
        }
        $reservation->setUtilisateur($user);

        $voyageId = $username = $this->getRequest()->get('voyageId');
        $voyage = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Voyage')
            ->find($voyageId);
        if ($voyage) {
            $reservation->setVoyage($voyage);
        }

        $reservation->setStatus(Reservation::PENDING);
        $em->persist($reservation);
        $em->flush();

        //@TODO:
        //send confirmation/notification email for both users
        // finish with real params
        $mailer = $this->get('mailer');
        $subject = 'Confirmation Réservation';
        $from = $this->container->getParameter('no_reply_email');
        $to ='alger.tunisien@gmail.com';
        $body = $this->renderView('CovoiturageFrontendBundle:Reservation:email_reservation_demande.txt.twig', array('source' => 'Ariana','dest'=>"Manouba","link"=>"".$reservation->getId()."/confirmation"));
        $mailingHelper = new MailingHelper($mailer,$to,$from,$subject,$body);
        $mailingHelper->send();


        $ret['status'] = '200';
        return new JsonResponse($ret);
    }

}
