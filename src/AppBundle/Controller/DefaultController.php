<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscriber;
use Minishlink\WebPush\VAPID;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/{route}", name="vue_sub_pages", requirements={"route"=".+"})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'vapidPublicKey' => $this->getParameter("webpush.publickey")
        ]);
    }


     /**
     * @Route("/notification/register", name="notification_register")
     * @Method("POST")
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $is_new = false;
        // looking for better approach ? look in  http://labs.qandidate.com/blog/2014/08/13/handling-angularjs-post-requests-in-symfony/
        $data = json_decode($request->getContent(), true);
        $is_subscribed = $em->getRepository("AppBundle:Subscriber")->findOneBy(['endpoint' => $data['endpoint']]);
        if(is_null($is_subscribed)){
            $is_new = true;
            $subscriber = new Subscriber();
            $subscriber->setEnabled(1);
            $subscriber->setBrowserKey($data['key']);
            $subscriber->setEndpoint($data['endpoint']);
            $subscriber->setAuthSecret($data['authSecret']);
            $em->persist($subscriber);
            $em->flush();
        }
        return  new JsonResponse(array('new' => $is_new, "success" => true));
    }

    /**
     * @Route("/notification/unregister", name="notification_unregister")
     * @Method("POST")
     */
    public function unregisterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);
        $is_subscribed = $em->getRepository("AppBundle:Subscriber")->findOneBy(['endpoint' => $data['endpoint']]);
        if (!$is_subscribed) {
            throw $this->createNotFoundException('No found');
        }
        $em->remove($is_subscribed);
        $em->flush();
        return  new JsonResponse(array("removed" => true));
    }
}
