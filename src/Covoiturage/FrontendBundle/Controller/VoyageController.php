<?php
/**
 *
 * User: wissem
 * Date: 03/11/2014
 * Time: 23:30
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Controller;

use Covoiturage\FrontendBundle\Entity\Voyage;
use Covoiturage\FrontendBundle\Form\Type\VoyageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Covoiturage\FrontendBundle\Helper\UserReservation;



class VoyageController extends Controller
{
    public function publishAction(Request $request)
    {
        $voyage = new Voyage();

        $form = $this->get('form.factory')->create(new VoyageType(), $voyage);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            if (!$user) {
                // pass voyage as on object to user session
                $session = $this->getRequest()->getSession();
                $session->set('voyage',$voyage);
                // redirect to user login
                return $this->redirect($this->generateUrl('fos_user_security_login'));
            }
            $voyage->setUtilisateur($user);
            $em->persist($voyage);
            $em->flush();

            //@TODO:
            // add session message
            // redirect to Voyage(navette) view
        }

        return $this->render('CovoiturageFrontendBundle:Voyage:publish.html.twig',
                    array(
                        'form' => $form->createView()
                    )
        );
    }

    public function modifyAction(Voyage $voyage)
    {

        $form = $this->get('form.factory')->create(new VoyageType(), $voyage);

        $request = $this->get('request');

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $voyage->setUtilisateur($user);
            $em->persist($voyage);
            $em->flush();

            //@TODO:
            // add session message
            // redirect to Voyage(navette) view
        }

        return $this->render('CovoiturageFrontendBundle:Voyage:modify.html.twig',
            array(
                 'voyage' => $voyage,
                'form' => $form->createView()
            )
        );
    }

    public function deleteAction(Voyage $voyage)
    {
        if (!$voyage) {
            throw new NotFoundHttpException('Introuvable');
        }
        $user = $this->getUser();
        if ($voyage->getUtilisateur() != $user) {
            throw new AccessDeniedException('Vous n\'avez pas les droits pour faire ça!');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($voyage);
        $em->flush();

        //@TODO:
        // add session message
        // redirect user Voyage

        return new Response('OK.');

    }
    public function showAction(Voyage $voyage)
    {
        if (!$voyage) {
            throw new NotFoundHttpException('Introuvable');
        }

        $listVoyages = array($voyage);
        $user = $this->getUser();
        $userReservationHelper = new UserReservation($user,$listVoyages,$this->getDoctrine());
        $userReservations = $userReservationHelper->setUserReservations();

        return $this->render('CovoiturageFrontendBundle:Voyage:show.html.twig',
            array(
                'voyage' => $voyage,
                'user_reservations'=>$userReservations
            )
        );

    }

    public function listAction($page)
    {
        $maxPerPage  = $this->container->getParameter('max_per_page');
        $listVoyages = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Voyage')
            ->getList($page, $maxPerPage);
        $voyagesCount = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Voyage')
            ->countVoyages();
        $pagination = array(
            'page' => $page,
            'route' => 'covoiturage_frontend_voyage_list',
            'pages_count' => ceil($voyagesCount / $maxPerPage),
            'route_params' => array('page'=>$page)
        );
        $user = $this->getUser();
        $userReservationHelper = new UserReservation($user,$listVoyages,$this->getDoctrine());
        $userReservations = $userReservationHelper->setUserReservations();

        return $this->render('CovoiturageFrontendBundle:Voyage:list.html.twig',                      array('list_voyages'    => $listVoyages,
                'pagination'      => $pagination,
                'user_reservations'=>$userReservations
            )
        );
    }

}
