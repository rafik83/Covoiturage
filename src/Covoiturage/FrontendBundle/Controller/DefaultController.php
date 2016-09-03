<?php

namespace Covoiturage\FrontendBundle\Controller;

use Covoiturage\FrontendBundle\Helper\UserReservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\Expr;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr as QueryExpr;


class DefaultController extends Controller
{
    public function indexAction()
    {


        return $this->render('CovoiturageFrontendBundle:Default:index.html.twig',                                       array(
            )
        );
    }

    public function searchAction(Request $request,$page = 1)
    {

        $depart = $request->query->get('depart');
        $arrive = $request->query->get('arrive');
        $date = $request->query->get('date');

        $criteria = array(
            'idDepart' => $depart,
            'idArrive' => $arrive,
            'horaire'  => $date,
        );


        $maxPerPage =$this->container->getParameter('max_per_page');

        $listOffres = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Voyage')->searchVoyages($criteria,$page,$maxPerPage);



        $voyagesCount = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:Voyage')
            ->countVoyagesSearch($criteria);

        $pagination = array(
            'page' => $page,
            'route' => 'covoiturage_frontend_search',
            'pages_count' => ceil($voyagesCount / $maxPerPage),
            'route_params' => array(
                                'page'=>$page,
                                'depart'=>$depart,
                                'arrive'=>$arrive,
                                'date'=>$date
                            )
        );

        $user = $this->getUser();
        $userReservationHelper = new UserReservation($user,$listOffres,$this->getDoctrine());
        $userReservations = $userReservationHelper->setUserReservations();


        return $this->render('CovoiturageFrontendBundle:Voyage:search.html.twig',                                     array(    'list_voyages' => $listOffres,
                                      'pagination' => $pagination,
                                      'user_reservations'=>$userReservations,
                                      'count_voyages'=>$voyagesCount,
                                      'depart'=>$depart,
                                      'arrive'=>$arrive,
                                      'date_form'=>$date,
                    )
        );
    }

    public function getOffreAction()
    {

    }

    public function addOffreAction()
    {

    }

    public function getConnectionAction()
    {

    }

    /**
     * @return Response
     */
    public function getAllGouvernoratsAction()
    {
        $listGouvernorats = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:gouvernorat')->findAll();
        //var_dump($listOffres);
        return $this->render('CovoiturageFrontendBundle:_common:selection.html.twig', array('list_items' => $listGouvernorats));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function getAllDelegationsAction($id = null)
    {
        $listDelegations = $this->getDoctrine()->getRepository('CovoiturageFrontendBundle:delegation')->matching( new Criteria( new Expr\Comparison( "idGouvernorat",Expr\Comparison::EQ,"2")));
        //var_dump($listOffres);
        return $this->render('CovoiturageFrontendBundle:_common:selection.html.twig', array('list_items' => $listDelegations));
    }
}
