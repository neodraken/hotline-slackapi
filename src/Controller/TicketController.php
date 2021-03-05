<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Notifier\TicketNotification;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{

    private $manager;
    private $logger;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $manager)
    {
        $this->logger = $logger;
        $this->manager = $manager;
    }


    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, NotifierInterface $notifier)
    {

        //Ticket form 
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($ticket);
            $this->manager->flush();
            
            //send ticket message to slack channel
            $notification = new TicketNotification($ticket);
            $notifier->send($notification);

            return $this->redirectToRoute('homepage');
        }


        return $this->render('ticket/index.html.twig', [
            'ticket_form' => $form->createView()
        ]);
    }
}
