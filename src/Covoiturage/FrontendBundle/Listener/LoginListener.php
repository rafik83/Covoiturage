<?php
/**
 * 
 * User: wissem
 * Date: 19/12/2014
 * Time: 20:49
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Listener;

use FOS\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\FOSUserBundle;


class LoginListener implements EventSubscriberInterface
{
    /**
     * @var Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;

    private $session;

    private $router;

    public function __construct(Doctrine $doctrine, Session $session, RouterInterface $router)
    {
        $this->doctrine = $doctrine;
        $this->session  = $session;
        $this->router   = $router;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onImplicitLogin',
            FOSUserEvents::REGISTRATION_COMPLETED=> 'onRegistrationCompleted'
        );
    }

    public function onImplicitLogin(UserEvent $event)
    {
        $user = $event->getUser();
        $this->completeVoyageCreation($user);
    }

    public function onRegistrationCompleted(UserEvent $event)
    {
        $user = $event->getUser();
        $this->completeVoyageCreation($user);
    }

    public function completeVoyageCreation($user)
    {

        if ($user) {
            if ($this->session->has('voyage')) {
                $voyage = $this->session->get('voyage');
                $voyage->setUtilisateur($user);
                $this->doctrine->getManager()->persist($voyage);
                $this->doctrine->getManager()->flush();

                $this->session->getFlashBag()->add('notice','Votre navette a été crée');
            }

        }
    }

} 