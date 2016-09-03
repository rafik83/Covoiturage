<?php
/**
 *
 * User: wissem
 * Date: 02/11/2014
 * Time: 22:10
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Covoiturage\FrontendBundle\Helper\UserReservation;




class UserController extends Controller
{
    public function loginAction()
    {
        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return $this->render('CovoiturageFrontendBundle:_common:login.html.twig',
                array(
                    'csrf' => $csrfToken,
                )
        );
    }

    public function voyagesAction($page)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirect($this->generateUrl('covoiturage_frontend_homepage'));
        }


        $maxPerPage =$this->container->getParameter('max_per_page');
        $userlistVoyages = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Voyage')
            ->getUserList($user->getId(),$page, $maxPerPage);

        $userVoyagesCount = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Voyage')
            ->countUserVoyages($user->getId());
        $pagination = array(
            'page' => $page,
            'route' => 'covoiturage_frontend_voyage_user',
            'pages_count' => ceil($userVoyagesCount / $maxPerPage),
            'route_params' => array('page'=>$page)
        );

        $user = $this->getUser();
        $userReservationHelper = new UserReservation($user,$userlistVoyages,$this->getDoctrine());
        $userReservations = $userReservationHelper->setUserReservations();

        return $this->render('CovoiturageFrontendBundle:User:mes_voyages.html.twig',                                       array('list_voyages'    => $userlistVoyages,
                                     'pagination'      => $pagination,
                                        'user_reservations'=>$userReservations,
                )
        );

    }


}
