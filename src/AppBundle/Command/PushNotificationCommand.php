<?php

namespace AppBundle\Command;

use AppBundle\Entity\Subscriber;
use Minishlink\WebPush\VAPID;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Minishlink\WebPush\WebPush;

class PushNotificationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('push:notification')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /** @var WebPush  $webPush */
        $webPush = $this->getContainer()->get("minishlink_web_push");

        $em = $this->getContainer()->get('doctrine')->getManager();
        $repository = $em->getRepository("AppBundle:Subscriber");
        $subscribers = $repository->findBy(["enabled" => 1]);

        $notification = json_encode([
            "icon" => "https://cdn1.iconfinder.com/data/icons/twitter-ui-colored/48/JD-24-128.png",
            "title" => "this is a title",
            "tag" => "SymfonyPushNotification",
            "body" => "this is the body!!!",
            "url" => "https://google.com/"
        ]);

        /** @var Subscriber $subscriber */
        foreach($subscribers as $subscriber){
            $webPush->sendNotification($subscriber->getEndpoint() , $notification , $subscriber->getBrowserKey() , $subscriber->getAuthSecret() , false);
            $output->writeln("I've sent a notification!");
        }
        $responses = $webPush->flush();
        foreach($responses as $response){
            switch ($response["success"]){
                case false:
                        $output->writeln($response["message"]);
                    break;
                case true:
                    /// no need to bother the user with success ones
                    break;
            }
        }
    }
}
