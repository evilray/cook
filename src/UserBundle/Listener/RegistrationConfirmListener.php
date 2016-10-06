<?php

namespace UserBundle\Listener;

use FOS\UserBundle\FOSUserEvents;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class RegistrationConfirmListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router, $dispatcher)
    {

        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {

        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationConfirm'
        );
    }

    public function onRegistrationConfirm(\FOS\UserBundle\Event\FormEvent $event)
    {
        $url = $this->router->generate('homepage');

        $event->setResponse(new RedirectResponse($url));
    }

}