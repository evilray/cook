<?php

namespace UserBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class CacheListener {

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $response->setPrivate();
        $response->setMaxAge(0);
        $response->setSharedMaxAge(0);

        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);
    }

}
