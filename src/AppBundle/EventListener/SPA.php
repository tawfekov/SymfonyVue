<?php
/**
 * Created by PhpStorm.
 * User: tawfek
 * Date: 8/8/17
 * Time: 2:16 PM
 */

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class SPA
{
    /**
     * Holds Symfony2 router
     *
     * @var Router
     */
    protected $router;

    /**
     * SPA constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {

        $exception = $event->getException();

        if ($exception instanceof NotFoundHttpException) {

            /** Choose your router here */
            $route = 'homepage';

            if ($route === $event->getRequest()->get('_route')) {
                return;
            }


            $url = $this->router->generate($route);
            $response = new RedirectResponse($url);
            $event->setResponse($response);

        }
    }
}