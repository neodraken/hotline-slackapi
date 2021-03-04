<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request)
    {

        //Ticket form 
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            //persist datas
            $this->manager->persist($ticket);
            $this->manager->flush();
            
            //send to slack
        }


        return $this->render('ticket/index.html.twig', [
            'ticket_form' => $form->createView()
        ]);
    }
}
